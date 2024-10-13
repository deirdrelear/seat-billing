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
        $user = auth()->user();
        
        $characterIds = $user->characters->pluck('character_id')->toArray();
        
        $corporationIds = DB::table('corporation_members')
            ->whereIn('character_id', $characterIds)
            ->pluck('corporation_id')
            ->unique()
            ->toArray();
    
        $structures = CorporationStructure::whereIn('corporation_id', $corporationIds)
            ->where('type_id', 81826) // Metenox Moon Drill
            ->get();
    
        $structuresWithCorporations = $structures->map(function ($structure) {
            $corporation = CorporationInfo::find($structure->corporation_id);
            $structure->corporation = $corporation;
            return $structure;
        });
    
        return view('billing::moondrills', compact('structuresWithCorporations'));
    }
}