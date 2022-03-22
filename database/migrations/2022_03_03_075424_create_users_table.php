<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('prenom', 255)->nullable()->default('');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('is_admin')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->integer('is_active')->default(1);
            $table->string('identite', 255)->nullable();
            $table->string('sexe', 10)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('profile', 255)->nullable();
            $table->integer('country_id')->nullable();
            $table->float('solde', 10, 0)->default(0);
            $table->integer('admin_level')->default(2);
            $table->string('phone', 255)->nullable()->default('0123456789');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
