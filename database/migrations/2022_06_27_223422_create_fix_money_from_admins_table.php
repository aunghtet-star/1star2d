<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixMoneyFromAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fix_money_from_admins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_user_id');
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('trx_id')->unique();
            $table->string('is_deposit')->comment('withdraw,deposit');
            $table->string('amount');
            $table->string('type');
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
        Schema::dropIfExists('fix_money_from_admins');
    }
}
