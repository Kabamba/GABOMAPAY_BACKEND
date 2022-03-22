<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetraitRdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retrait_rdcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->index('retrait_rdcs_transaction_id_foreign');
            $table->unsignedBigInteger('operator_id')->index('retrait_rdcs_operator_id_foreign');
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
        Schema::dropIfExists('retrait_rdcs');
    }
}
