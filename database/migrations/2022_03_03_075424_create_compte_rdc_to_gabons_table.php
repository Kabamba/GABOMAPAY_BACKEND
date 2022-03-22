<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompteRdcToGabonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_rdc_to_gabons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->index('compte_rdc_to_gabons_transaction_id_foreign');
            $table->unsignedBigInteger('recever_id')->index('compte_rdc_to_gabons_recever_id_foreign');
            $table->double('montant_total', 8, 2);
            $table->double('montant_convertit', 8, 2);
            $table->double('taux_convers', 8, 2);
            $table->float('pourcentage_int', 10, 0);
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
        Schema::dropIfExists('compte_rdc_to_gabons');
    }
}
