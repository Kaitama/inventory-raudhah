<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Section;
use App\Models\Inventory;

class Kasi extends Model
{
	use HasFactory, SoftDeletes;

	protected $guarded = [];
	
	public function section()
	{
		return $this->belongsTo(Section::class);
	}

	public function inventories()
	{
		return $this->hasMany(Inventory::class);
	}
}