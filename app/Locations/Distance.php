<?php

namespace App\Locations;

use Exception;
use Illuminate\Support\Facades\DB;

trait Distance
{
    protected string $googleAPI = 'AIzaSyD6oocLsENVVTWHKooR4xHVVS-ILXsA274';
    protected string $googleDistanceMatrixAPI = 'https://maps.googleapis.com/maps/api/geocode/json';
    protected $lat;
    protected $lng;

    /**
     * Get Lattiude and Longitude from Address.
     *
     * @param   string  $address  Address
     *
     * @return void
     */
    protected function getLatLong($address)
    {
        try {
            $searchedLocations = file_get_contents($this->googleDistanceMatrixAPI . '?address=' . urlencode($address) . '&key=' . $this->googleAPI);
            $searchedLocations = json_decode($searchedLocations);
            if ($searchedLocations->status == 'OK') {
                $this->lat = $searchedLocations->results[0]->geometry->location->lat;
                $this->lng = $searchedLocations->results[0]->geometry->location->lng;
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get Distance between two locations.
     *
     * @return  Collection  Searched Locations
     */
    protected function locations($address)
    {
        $locations = array();

        if ($address) {
            if ($this->getLatLong($address)) {
                $locations = DB::select(DB::raw("SELECT*, (
                                            3959 * acos (
                                            cos ( radians(" . $this->lat . ") )
                                            * cos( radians( geo_lat ) )
                                            * cos( radians( geo_lng ) - radians(" . $this->lng . ") )
                                            + sin ( radians(" . $this->lat . ") )
                                            * sin( radians( geo_lat ) )
                                            )
                                            ) AS distance
                                            FROM locations
                                            HAVING distance < 50
                                            ORDER BY distance
                                            LIMIT 0 , 20"));
                return $locations;
            }
        }
        return [];
    }
}
