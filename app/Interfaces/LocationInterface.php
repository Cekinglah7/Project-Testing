<?php

namespace App\Interfaces;

interface LocationInterface
{
    public function getZones($search = null);
    public function getAreasByZone($zoneId, $search = null);
}
