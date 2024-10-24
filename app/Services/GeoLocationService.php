<?php

namespace App\Services;

use ipinfo\ipinfo\IPinfo; // Correct namespace with correct casing

class GeoLocationService
{
    protected $ipinfo;

    public function __construct()
    {
        // Make sure the token is being retrieved from the environment variables
        $this->ipinfo = new Ipinfo(env('IPINFO_TOKEN')); // Use the environment variable for your token
    }

    public function getLocation()
    {
        return $this->ipinfo->getDetails(); // This will return the location details
    }
}
