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
		var_dump($from, $to, $unit);
		//return $distance;
	}

	/**
	 * @param array $from
	 * @param array $offices
	 *
	 * @return array
	 */
	public function findClosestOffice( $from, $offices ) {

		//return $office;
	}

}