<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::beginTransaction();

        Schema::create('software_keys', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->timestamps();
            $table->string('title');
            $table->string('key', 100)->unique();
            $table->unsignedTinyInteger('platform_id')->nullable()->index();
            $table->text('shop_link')->nullable();
            $table->text('back_img_link')->nullable();
            $table->text('instruction_link')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->boolean('raffled')->default(false);
        });

        Schema::table('software_keys', function (Blueprint $table) {
			$table->foreign('parent_id')
				->references('id')
				->on('software_keys')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('set null');

			$table->foreign('platform_id')
				->references('id')
				->on('platforms')
				->onUpdate('cascade')
				->onDelete('set null');
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
        Schema::dropIfExists('software_keys');
    }
}
