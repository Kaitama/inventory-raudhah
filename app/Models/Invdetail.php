<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Inventory;
use App\Models\Maintenance;
use App\Models\Maintainreport;

class Invdetail extends Model
{
	use HasFactory, SoftDeletes;
	protected $guarded = [];
	
	public function inventory()
	{
		return $this->belongsTo(Inventory::class);
	}

	public function maintenances()
	{
		return $this->hasMany(Maintenance::class);
	}
	
	public function reportings()
	{
		return $this->hasMany(Maintainreport::class);
	}
}