<?php

namespace App\Services\Email;

use App\Helpers\MailHelper;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\Setting;
use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Message;

class EmailDispatcher
{
    /**
     * Maps event_key → SmtpSetting boolean column.
     * Events absent from this map have no global toggle and go straight to Guard 2.
     */
    private static array $columnMap = [
        'welcome' => 'welcome',
        'order-confirmed' => 'order_confirmation',
        'order-shipped' => 'order_shipped',
        'order-delivered' => 'order_delivered',
        'order-cancelled' => 'order_cancelled',
        'payment-received' => 'payment_received',
        'coupon' => 'coupon',
        'password-reset' => 'password_reset',
        'new-order-alert' => 'new_order_alert',
        'low-stock-alert' => 'low_stock_alert',
    ];


    private static function globalVariables(): array
    {
        $settings = Setting::first();

        return [
            '{store_name}' => $settings?->site_name ?? config('app.name'),
            '{brand_name}' => $settings?->site_name ?? config('app.name'),

            '{logo_url}' => !empty($settings?->logo)
                ? asset('storage/' . $settings->logo)
                : '',

            '{shop_url}' => route('home'),
            '{store_url}' => route('home'),
            '{login_url}' => route('user.login'),

            '{support_number}' => $settings?->phone ?? '',
            '{support_email}' => $settings?->admin_email ?? '',

            '{tagline}' => $settings?->tagline ?? '',
        ];
    }

    /**
     * Auto-extract a reference (e.g. order number) from the variables
     * passed to send(), if one is present. No call sites need to change.
     */
    private static function extractReference(array $variables): ?string
    {
        return $variables['{order_number}'] ?? null;
    }

    /**
     * Resolve, render, and send an email for a given event.
     *
     * Guard 1 — SmtpSetting per-event toggle must be enabled.
     * Guard 2 — EmailTemplate row must exist and be enabled.
     * Both must pass for the email to be sent.
     *
     * @param  string       $eventKey   e.g. 'order-confirmed', 'welcome', 'password-reset'
     * @param  string       $to         Recipient email address
     * @param  array        $variables  e.g. ['{customer_name}' => 'Rahul', '{order_id}' => 'ORD-001']
     * @param  string|null  $toName     Recipient display name (optional)
     * @return array{success: bool, response: mixed}
     */
    public static function send(string $eventKey, string $to, array $variables = [], ?string $toName = null): array
    {
        $reference = self::extractReference($variables);

        $smtp = SmtpSetting::getInstance();

        // ── Guard 1: SmtpSetting per-event toggle ─────────────────────────────
        $smtpCol = self::$columnMap[$eventKey] ?? null;

        if ($smtpCol && empty($smtp->{$smtpCol})) {
            Log::info("EmailDispatcher: '{$eventKey}' blocked by SMTP settings toggle ({$smtpCol} = false).");

            EmailLog::create([
                'event_key' => $eventKey,
                'to_email' => $to,
                'to_name' => $toName,
                'subject' => null,
                'status' => 'blocked',
                'reference' => $reference,
                'error_message' => "Event '{$eventKey}' is disabled in SMTP settings.",
                'meta' => $variables,
            ]);

            return [
                'success' => false,
                'response' => "Event '{$eventKey}' is disabled in SMTP settings.",
            ];
        }

        // ── Guard 2: EmailTemplate must exist and be enabled ──────────────────
        $template = EmailTemplate::where('event_key', $eventKey)
            ->where('enabled', true)
            ->first();

        if (!$template || empty($template->body)) {
            Log::warning("EmailDispatcher: template '{$eventKey}' not found or disabled.");

            EmailLog::create([
                'event_key' => $eventKey,
                'to_email' => $to,
                'to_name' => $toName,
                'subject' => null,
                'status' => 'blocked',
                'reference' => $reference,
                'error_message' => "Template '{$eventKey}' not configured or disabled.",
                'meta' => $variables,
            ]);

            return [
                'success' => false,
                'response' => "Template '{$eventKey}' not configured or disabled.",
            ];
        }

        $variables = array_merge(
            self::globalVariables(),
            $variables
        );
        // ── Render: replace {variables} in subject and body ───────────────────
        $subject = str_replace(
            array_keys($variables),
            array_values($variables),
            $template->subject ?? ''
        );

        $body = str_replace(
            array_keys($variables),
            array_values($variables),
            $template->body
        );

        // ── Resolve from / reply-to (template overrides SmtpSetting fallback) ─
        $fromName = $template->from_name ?? $smtp->from_name ?? config('mail.from.name');
        $fromEmail = $template->from_email ?? $smtp->from_email ?? config('mail.from.address');
        $replyName = $template->reply_to_name ?? $smtp->reply_to_name ?? null;
        $replyEmail = $template->reply_to_email ?? $smtp->reply_to_email ?? null;
        $cc = $template->cc ?? null;

        MailHelper::configure();

        // ── Send ──────────────────────────────────────────────────────────────
        try {
            Mail::html($body, function (Message $msg) use ($to, $toName, $subject, $fromName, $fromEmail, $replyName, $replyEmail, $cc) {
                $msg->to($to, $toName)
                    ->subject($subject)
                    ->from($fromEmail, $fromName);

                if ($replyEmail) {
                    $msg->replyTo($replyEmail, $replyName);
                }

                if ($cc) {
                    $msg->cc($cc);
                }
            });

            EmailLog::create([
                'event_key' => $eventKey,
                'to_email' => $to,
                'to_name' => $toName,
                'subject' => $subject,
                'status' => 'sent',
                'reference' => $reference,
                'error_message' => null,
                'meta' => $variables,
            ]);

            return ['success' => true, 'response' => "Email sent to {$to}"];

        } catch (\Throwable $e) {
            Log::error("EmailDispatcher: exception for '{$eventKey}'.", [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);

            EmailLog::create([
                'event_key' => $eventKey,
                'to_email' => $to,
                'to_name' => $toName,
                'subject' => $subject,
                'status' => 'failed',
                'reference' => $reference,
                'error_message' => $e->getMessage(),
                'meta' => $variables,
            ]);

            return ['success' => false, 'response' => $e->getMessage()];
        }
    }

    /**
     * Same as send() but bypasses BOTH guards.
     * Used exclusively by admin test sends — always attempts delivery
     * regardless of SmtpSetting toggles or EmailTemplate enabled flag.
     *
     * Not logged to email_logs — test sends are ad-hoc admin actions,
     * not real customer-facing events.
     *
     * @param  string       $eventKey
     * @param  string       $to
     * @param  array        $variables
     * @param  string|null  $toName
     * @return array{success: bool, response: mixed}
     */
    public static function sendTest(string $eventKey, string $to, array $variables = [], ?string $toName = null): array
    {
        $template = EmailTemplate::where('event_key', $eventKey)->first();

        if (!$template || empty($template->body)) {
            return [
                'success' => false,
                'response' => "Template '{$eventKey}' not configured.",
            ];
        }

        $subject = str_replace(
            array_keys($variables),
            array_values($variables),
            $template->subject ?? '(No Subject)'
        );

        $body = str_replace(
            array_keys($variables),
            array_values($variables),
            $template->body
        );

        $smtp = SmtpSetting::getInstance();
        $fromName = $template->from_name ?? $smtp->from_name ?? config('mail.from.name');
        $fromEmail = $template->from_email ?? $smtp->from_email ?? config('mail.from.address');
        $replyName = $template->reply_to_name ?? $smtp->reply_to_name ?? null;
        $replyEmail = $template->reply_to_email ?? $smtp->reply_to_email ?? null;
        MailHelper::configure();

        try {
            Mail::html($body, function (Message $msg) use ($to, $toName, $subject, $fromName, $fromEmail, $replyName, $replyEmail) {
                $msg->to($to, $toName)
                    ->subject($subject)
                    ->from($fromEmail, $fromName);

                if ($replyEmail) {
                    $msg->replyTo($replyEmail, $replyName);
                }
            });

            return ['success' => true, 'response' => "Test email sent to {$to}"];

        } catch (\Throwable $e) {
            Log::error("EmailDispatcher test exception for '{$eventKey}'.", [
                'error' => $e->getMessage(),
            ]);

            return ['success' => false, 'response' => $e->getMessage()];
        }
    }
}