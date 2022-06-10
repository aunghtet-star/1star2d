<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreePoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('three_pouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_user_id');
            $table->bigInteger('user_id');
            $table->decimal('amount');
            $table->string('three');
            $table->date('date');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('three_pouts');
    }
}
