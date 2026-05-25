<?php

namespace App\Repositories;

use App\Models\Zone;
use App\Models\Area;
use App\Interfaces\LocationInterface;

class LocationRepository implements LocationInterface
{
    public function getZones($search = null)
    {
        $query = Zone::query();

        $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->get();
    }

    public function getAreasByZone($zoneId, $search = null)
    {
        $query = Area::where('zone_id', $zoneId);

        $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->get();
    }
}