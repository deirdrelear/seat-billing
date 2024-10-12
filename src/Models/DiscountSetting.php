<?php

namespace Denngarr\Seat\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountSetting extends Model
{
    protected $table = 'seat_billing_discount_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getSetting($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setSetting($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}