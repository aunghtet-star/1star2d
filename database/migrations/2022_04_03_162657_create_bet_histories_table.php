<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_user_id');
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('trx_id')->unique();
            $table->string('is_deposit')->comment('bet,win');
            $table->string('amount');
            $table->string('type')->comment('2d,3d');
            $table->date('date');
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
        Schema::dropIfExists('bet_histories');
    }
}
