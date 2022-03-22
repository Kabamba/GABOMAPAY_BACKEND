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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->index('gabon_to_mobile_rdcs_transaction_id_foreign');
            $table->unsignedBigInteger('operator_id')->index('gabon_to_mobile_rdcs_operator_id_foreign');
            $table->double('montant_total', 8, 2);
            $table->double('montant_convertit', 8, 2);
            $table->double('pourcentage_int', 8, 2);
            $table->double('pourcentage_operator', 8, 2);
            $table->double('taux_convers', 8, 2);
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
