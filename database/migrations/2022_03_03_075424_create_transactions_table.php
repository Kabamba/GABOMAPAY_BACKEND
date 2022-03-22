<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('montant', 10, 0);
            $table->date('date_trans')->nullable();
            $table->dateTime('date_time_trans')->useCurrent();
            $table->string('reference')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('type_trans')->nullable();
            $table->unsignedBigInteger('user_id')->index('transacrtions_user_id_foreign');
            $table->integer('second_id')->nullable();
            $table->timestamps();
            $table->integer('country_id');
            $table->text('raison')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
