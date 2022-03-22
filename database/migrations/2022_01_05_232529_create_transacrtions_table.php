<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacrtionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacrtions', function (Blueprint $table) {
            $table->id();
            $table->float('montant');
            $table->date('date_trans');
            $table->dateTime('date_time_trans');
            $table->string('billing_id');
            $table->string('reference');
            $table->integer('status');
            $table->integer('type_trans');
            $table->string('paie_syst');
            $table->string('capture');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('transacrtions');
    }
}
