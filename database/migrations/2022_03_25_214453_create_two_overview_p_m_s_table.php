<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwoOverviewPMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('two_overview_p_m_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->string('two')->nullable();
            $table->date('date')->nullable();
            $table->decimal('amount', 20)->default('0')->nullable();
            $table->decimal('new_amount', 20)->default('0')->nullable();
            $table->decimal('kyon_amount', 20)->default('0')->nullable();
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
        Schema::dropIfExists('two_overview_p_m_s');
    }
}
