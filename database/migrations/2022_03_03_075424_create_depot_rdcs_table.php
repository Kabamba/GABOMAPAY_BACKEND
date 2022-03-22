<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotRdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_rdcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('montant_total', 10, 0);
            $table->unsignedBigInteger('transaction_id')->index('depot_rdcs_transaction_id_foreign');
            $table->string('capture')->nullable();
            $table->integer('operator_id');
            $table->float('pourcentage', 10, 0);
            $table->float('montant_frais', 10, 0);
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
        Schema::dropIfExists('depot_rdcs');
    }
}
