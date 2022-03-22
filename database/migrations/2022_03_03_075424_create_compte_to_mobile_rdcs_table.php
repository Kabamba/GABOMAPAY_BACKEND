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
            $table->bigIncrements('id');
            $table->integer('transaction_id');
            $table->unsignedBigInteger('operator_id')->index('compte_to_mobile_rdcs_operator_id_foreign');
            $table->string('recever_number');
            $table->double('montant_total', 8, 2);
            $table->double('pourcentage', 8, 2);
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
