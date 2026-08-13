<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use App\Models\SmtpSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $settings;
    public $productImages = [];

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $this->order->load([
            'items.product',
            'items.variant.values.attributeValue.attribute',
            'state',
            'city',
            'courier',
        ]);

        $this->settings = Setting::first();

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        $logoPath = null;

        if ($this->settings?->logo) {
            $path = storage_path(
                'app/public/' . $this->settings->logo
            );
            if (file_exists($path)) {
                $logoPath = $path;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Product Images (inline embed)
        |--------------------------------------------------------------------------
        */

        foreach ($this->order->items as $item) {

            if (!$item->product?->display_image) {
                continue;
            }

            $relativePath = str_replace(
                asset('storage') . '/',
                '',
                $item->product->display_image
            );

            $imagePath = storage_path(
                'app/public/' . $relativePath
            );

            if (file_exists($imagePath)) {
                $this->productImages[$item->id] = $imagePath;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Build Mail
        |--------------------------------------------------------------------------
        */

        $mail = $this
            ->subject(
                'New Order Received – ' .
                $this->order->order_number
            )
            ->view('emails.admin-new-order')
            ->with([
                'order'         => $this->order,
                'settings'      => $this->settings,
                'logoPath'      => $logoPath,
                'productImages' => $this->productImages,
            ]);

        /*
        |--------------------------------------------------------------------------
        | SMTP From / Reply-To
        |--------------------------------------------------------------------------
        */

        $smtp = SmtpSetting::first();

        if ($smtp && !empty($smtp->from_email)) {
            $mail->from($smtp->from_email, $smtp->from_name);
        }

        if ($smtp && !empty($smtp->reply_to_email)) {
            $mail->replyTo($smtp->reply_to_email, $smtp->reply_to_name);
        }

        return $mail;
    }
}