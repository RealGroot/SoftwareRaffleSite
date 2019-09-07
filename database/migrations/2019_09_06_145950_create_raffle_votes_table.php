<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaffleVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::beginTransaction();

        Schema::create('raffle_votes', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->timestamps();
			$table->unsignedInteger('user_id');
			$table->unsignedBigInteger('software_id');
        });

        Schema::table('raffle_votes', function (Blueprint $table) {
        	$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('software_id')
				->references('id')
				->on('software_keys')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raffle_votes');
    }
}
