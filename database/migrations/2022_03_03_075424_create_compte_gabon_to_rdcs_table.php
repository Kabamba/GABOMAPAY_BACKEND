<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompteGabonToRdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_gabon_to_rdcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->index('compte_gabon_to_rdcs_transaction_id_foreign');
            $table->unsignedBigInteger('recever_id')->index('compte_gabon_to_rdcs_recever_id_foreign');
            $table->double('montant_total', 8, 2);
            $table->double('montant_convertit', 8, 2);
            $table->double('pourcentage_int', 8, 2);
            $table->float('taux_convers', 10, 0);
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
        Schema::dropIfExists('compte_gabon_to_rdcs');
    }
}
