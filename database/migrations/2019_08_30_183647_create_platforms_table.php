<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('platforms', function (Blueprint $table) {
			$table->tinyIncrements('id');
			$table->string('name', 40);
			$table->string('display_name', 40);
			$table->string('icon_name', 40)->nullable();
			$table->text('icon_url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('platforms');
	}
}
