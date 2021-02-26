<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Invdetail;

class Maintainreport extends Model
{
	use HasFactory, SoftDeletes;
	
	protected $guarded = [], $dates = ['reported_at'];
	
	public function invdetail()
	{
		return $this->belongsTo(Invdetail::class);
	}
}