<?php

namespace Denngarr\Seat\Billing\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Corporation\CorporationStructure;
use Illuminate\Support\Facades\DB;

class MoonDrillController extends Controller
{
    public function index()
    {
        $structures = DB::table('corporation_structures')
            ->select(DB::raw('COUNT(*) as count'), 'corporation_id')
            ->where('type_id', 81826)
            ->groupBy('corporation_id')
            ->get();

        return view('billing::moondrills', compact('structures'));
    }
}