<?php

namespace Denngarr\Seat\Billing\Http\Controllers;

use Denngarr\Seat\Billing\Models\DiscountSetting;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;

class DiscountSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'max_discount' => DiscountSetting::getSetting('max_discount', 20),
            'discount_per_fleet' => DiscountSetting::getSetting('discount_per_fleet', 1),
            'max_fleet_discount' => DiscountSetting::getSetting('max_fleet_discount', 20),
        ];

        return view('billing::discount_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_discount' => 'required|numeric|min:0|max:100',
            'discount_per_fleet' => 'required|numeric|min:0|max:100',
            'max_fleet_discount' => 'required|numeric|min:0|max:100',
        ]);

        DiscountSetting::setSetting('max_discount', $request->max_discount);
        DiscountSetting::setSetting('discount_per_fleet', $request->discount_per_fleet);
        DiscountSetting::setSetting('max_fleet_discount', $request->max_fleet_discount);

        return redirect()->back()->with('success', 'Настройки скидок успешно обновлены.');
    }
}