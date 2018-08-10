<?php
/**
 * Date: 30/07/2018
 * Time: 12:22
 * @author Artur Bartczak <artur.bartczak@code4.pl>
 */

namespace Proexe\BookingApp\Bookings\Models;

use Illuminate\Database\Eloquent\Model;
use Proexe\BookingApp\Offices\Models\OfficeModel;

/**
 * Class BookingModel
 * @package Proexe\BookingApp
 */
class BookingModel extends Model {

	protected $guarded = [];
	protected $table = 'bookings';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function office() {
		return $this->belongsTo( OfficeModel::class );
	}


}