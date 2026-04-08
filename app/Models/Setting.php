<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 */
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'APP_NAME',
        'APP_URL',
        'description',
        'keywords',
        'status',
        'logo',
        'favicon',
        'maintenance_message',
        'custom_html',
        'MAIL_MAILER',
        'MAIL_HOST',
        'MAIL_PORT',
        'MAIL_USERNAME',
        'MAIL_PASSWORD',
        'MAIL_ENCRYPTION',
        'MAIL_FROM_ADDRESS',
        'RECAPTCHA_SITE_KEY',
        'RECAPTCHA_SECRET_KEY',
        'locale'
    ];
}
