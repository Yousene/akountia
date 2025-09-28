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
            $table->id();
            $table->integer('role')->nullable();
            $table->integer('type')->default(1);
            $table->integer('client')->nullable();
            $table->integer('employe')->nullable();
            $table->string('login', 250)->nullable();
            $table->string('password', 255);
            $table->string('name', 255)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('confirmation_token', 500)->nullable();
            $table->string('photo', 250)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->integer('activated_by')->nullable();
            $table->integer('validated')->default(0);
            $table->timestamp('validated_at')->nullable();
            $table->integer('validated_by')->nullable();
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
