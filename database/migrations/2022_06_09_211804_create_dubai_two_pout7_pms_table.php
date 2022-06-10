<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDubaiTwoPout7PmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dubai_two_pout7_pms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_user_id');
            $table->bigInteger('user_id');
            $table->decimal('amount');
            $table->string('two');
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
        Schema::dropIfExists('dubai_two_pout7_pms');
    }
}
