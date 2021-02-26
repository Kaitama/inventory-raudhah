<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Kasi;

class Section extends Model
{
	use HasFactory, SoftDeletes;
	
	protected $guarded = [];

	public function kasis()
	{
		return $this->hasMany(Kasi::class);
	}
}