<?php

namespace Denngarr\Seat\Billing\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Corporation\CorporationStructure;

class MoonDrillController extends Controller
{
    public function index()
    {
        $structures = CorporationStructure::where('type_id', 81826)->take(5)->get();
        return view('billing::moondrills', compact('structures'));
    }
}