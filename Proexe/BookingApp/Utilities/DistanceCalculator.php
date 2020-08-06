<?php
/**
 * Date: 08/08/2018
 * Time: 16:20
 * @author Artur Bartczak <artur.bartczak@code4.pl>
 */

namespace Proexe\BookingApp\Utilities;


class DistanceCalculator {

	/**
	 * @param array  $from
	 * @param array  $to
	 * @param string $unit - m, km
	 *
	 * @return mixed
	 */
	public function calculate( $from, $to, $unit = 'm' ) {
        [$lat1,$lon1] = $from;
        [$lat2,$lon2] = $to;

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $km=$miles * 1.609344;
        if ($unit == "km") {
            return $km;
        } else if ($unit == "m") {
            return ($km*1000);
        }
	}

	/**
	 * @param array $from
	 * @param array $offices
	 *
	 * @return array
	 */
	public function findClosestOffice( $from, $offices ) {

        $results = [];
		foreach ($offices as $office){
            array_push($results,$this->calculate($from,[$office['lat'],$office['lng']], $unit = 'm'));
        }
        $position=array_keys($results, min($results));
        return $offices[$position[0]]['name'];
    }

// CREATE
// FUNCTION `calculate`(LatA DECIMAL(20,8), LngA DECIMAL(20,8), LatB DECIMAL(20,8), LngB DECIMAL(20,8))
// RETURNS DECIMAL(20,8)
// RETURN 60 * 1.1515 * 1.609344*
// DEGREES(ACOS(LEAST(1.0,
// SIN(RADIANS(LatA))
//  * SIN(RADIANS(LatB))
//  + COS(RADIANS(LatA))
//  * COS(RADIANS(LatB))
//  * COS(RADIANS(LngA - LngB))
// )));

// SELECT o.`id`, calculate($lat, $lng, o.`lat`, o.`lng`) as `km` FROM `offices` o ORDER BY `km` ASC LIMIT 1
}
