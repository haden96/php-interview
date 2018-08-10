<?php
/**
 * Date: 30/07/2018
 * Time: 12:48
 * @author Artur Bartczak <artur.bartczak@code4.pl>
 */
namespace Proexe\BookingApp\Offices\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeModel extends Model {

	protected $guarded = [];
	protected $table = 'offices';
	protected $casts = [
		'office_hours' => 'array'
	];

}