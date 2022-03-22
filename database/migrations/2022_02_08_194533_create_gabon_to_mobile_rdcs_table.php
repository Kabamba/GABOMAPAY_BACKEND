<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGabonToMobileRdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gabon_to_mobile_rdcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('operator_id')->constrained();
            $table->float('montant_total');
            $table->float('montant_convertit');
            $table->float('pourcentage_int');
            $table->float('pourcentage_operator');
            $table->float('taux_convers');
            $table->string('recever_number');
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
        Schema::dropIfExists('gabon_to_mobile_rdcs');
    }
}
