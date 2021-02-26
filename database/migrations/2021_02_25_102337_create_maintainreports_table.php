<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainreportsTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('maintainreports', function (Blueprint $table) {
			$table->id();
			$table->foreignId('invdetail_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamp('reported_at');
			$table->string('name');
			$table->string('phone')->nullable();
			$table->text('description')->nullable();
			$table->boolean('confirmed')->default(false);
			$table->softDeletes();
			$table->timestamps();
		});
	}
	
	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('maintainreports');
	}
}