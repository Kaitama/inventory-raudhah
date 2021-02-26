<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvdetailsTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('invdetails', function (Blueprint $table) {
			$table->id();
			$table->foreignId('inventory_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('barcode')->unique();
			$table->integer('condition')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('invdetails');
	}
}