<?php

namespace App;

class Helper {
    static function calculateDistance($start_lat, $start_long, $end_lat, $end_long, $earthRadius = 6371000) {
        //convert each of them to rad
        $start_lat = deg2rad($start_lat);
        $start_long = deg2rad($start_long);
        $end_lat = deg2rad($end_lat);
        $end_long = deg2rad($end_long);

        $latVal = $end_lat - $start_lat;
        $longVal = $end_long - $start_long;

        $angle = 2 * asin(sqrt(pow(sin($latVal / 2), 2) +
        cos($start_lat) * cos($end_lat) * pow(sin($longVal / 2), 2)));

        return $angle * $earthRadius;
    }
}