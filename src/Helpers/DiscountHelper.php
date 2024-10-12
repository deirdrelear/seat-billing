<?php

namespace Denngarr\Seat\Billing\Helpers;

use Denngarr\Seat\Billing\Models\DiscountSetting;
use Seat\Eveapi\Models\Calendar\CalendarEventAttendee;

trait DiscountHelper
{
    private function calculateDiscount($characterId, $userId, $year, $month)
    {
        $fleetDiscount = $this->calculateFleetDiscount($userId, $year, $month);
        
        $maxDiscount = DiscountSetting::getSetting('max_discount', 20);
        return min($fleetDiscount, $maxDiscount);
    }

    private function calculateFleetDiscount($userId, $year, $month)
    {
        $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $fleetParticipations = CalendarEventAttendee::where('user_id', $userId)
            ->whereHas('event', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate]);
            })
            ->count();

        $discountPerFleet = DiscountSetting::getSetting('discount_per_fleet', 1);
        $maxFleetDiscount = DiscountSetting::getSetting('max_fleet_discount', 20);

        return min($fleetParticipations * $discountPerFleet, $maxFleetDiscount);
    }
}