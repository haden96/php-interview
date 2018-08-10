<?php
/**
 * Date: 10/08/2018
 * Time: 13:51
 * @author Artur Bartczak <artur.bartczak@code4.pl>
 */

namespace Proexe\BookingApp\Offices\Interfaces;


interface ResponseTimeCalculatorInterface {

	public function calculate( $bookingDateTime, $responseDateTime, $officeHours );

}