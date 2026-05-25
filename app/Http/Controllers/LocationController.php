<?php

namespace App\Http\Controllers;
use App\Services\LocationService;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function zones(Request $request)
    {
        try {
            $search = $request->query('search');
            $zones = $this->locationService->getZones($search);
            
            return response()->json(['success' => true, 'data' => $zones], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function areas(Request $request)
    {
        try {
            $zoneId = $request->query('zone_id');
            $search = $request->query('search');
            
            $areas = $this->locationService->getAreas($zoneId, $search);
            
            return response()->json(['success' => true, 'data' => $areas], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
