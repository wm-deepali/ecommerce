<?php

namespace App\Helpers;

use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Config;

class MailHelper
{
    public static function configure()
    {
        $smtp = SmtpSetting::first();

        if (!$smtp) {
            return false;
        }

        Config::set('mail.default', 'smtp');

        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.host', $smtp->smtp_host);
        Config::set('mail.mailers.smtp.port', $smtp->smtp_port);
        Config::set('mail.mailers.smtp.username', $smtp->smtp_username);
        Config::set('mail.mailers.smtp.password', $smtp->smtp_password);
        Config::set('mail.mailers.smtp.encryption', $smtp->smtp_encryption === 'none'
            ? null
            : $smtp->smtp_encryption);

        Config::set('mail.from.address', $smtp->from_email);
        Config::set('mail.from.name', $smtp->from_name);

        return true;
    }
}