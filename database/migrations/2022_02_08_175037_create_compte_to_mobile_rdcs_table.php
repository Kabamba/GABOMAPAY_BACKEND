<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompteToMobileRdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_to_mobile_rdcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->constrained();
            $table->string('recever_number');
            $table->float('montant_total');
            $table->float('pourcentage');
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
        Schema::dropIfExists('compte_to_mobile_rdcs');
    }
}
