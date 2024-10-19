<?php

namespace Denngarr\Seat\Billing\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Corporation\CorporationStructure;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Illuminate\Support\Facades\DB;

class MoonDrillController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            
            $characterIds = $user->characters->pluck('character_id')->toArray();
            
            $corporationIds = DB::table('corporation_members')
                ->whereIn('character_id', $characterIds)
                ->pluck('corporation_id')
                ->unique()
                ->toArray();
    
            $structures = CorporationStructure::with('corporation')
                ->whereIn('corporation_id', $corporationIds)
                ->where('type_id', 81826) // Metenox Moon Drill
                ->get();
    
            return view('billing::moondrills', compact('structures'));
        } catch (\Exception $e) {
            \Log::error('Error in MoonDrillController: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }
}