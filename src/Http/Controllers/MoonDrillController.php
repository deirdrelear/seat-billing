<?php

namespace Denngarr\Seat\Billing\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Corporation\CorporationStructure;

class MoonDrillController extends Controller
{
    public function index()
    {
        $structures = CorporationStructure::where('type_id', 81826)
            ->select('structure_id', 'corporation_id')
            ->get();

        return view('billing::moondrills', compact('structures'));
    }
}