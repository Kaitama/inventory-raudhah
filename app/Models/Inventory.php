<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Kasi;
use App\Models\Invdetail;

class Inventory extends Model
{
	use HasFactory, SoftDeletes;
	
	protected $guarded = [], $dates = ['obtained_at'];

	public function kasi()
	{
		return $this->belongsTo(Kasi::class);
	}

	public function details()
	{
		return $this->hasMany(Invdetail::class);
	}
}