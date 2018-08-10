<?php

use Illuminate\Database\Seeder;

class SeedBookingTable extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$bookings = factory( \Proexe\BookingApp\Bookings\Models\BookingModel::class, 50 )->create()->each(function ($booking) {
			$date       = \Carbon\Carbon::create( 2018, 1, 1, 0, 0, 0 );
			$booking->created_at = $date->addWeeks( rand( 1, 25 ) )->addMinutes( rand( 1, 1400 ) )->toDateTimeString();
			$booking->updated_at = $date->addMinutes( rand( 40, 1500 ) );
			$booking->save();
		});
	}
}
