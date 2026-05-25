<?php

namespace App\Services;

use App\Interfaces\LocationInterface;

class LocationService
{
    protected $locationRepository;

    public function __construct(LocationInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getZones($search = null)
    {
        return $this->locationRepository->getZones($search);
    }

    public function getAreas($zoneId, $search = null)
    {
        if (!$zoneId) {
            throw new \Exception('Zone ID harus diisi');
        }
        return $this->locationRepository->getAreasByZone($zoneId, $search);
    }
}