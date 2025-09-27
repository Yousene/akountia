<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('type')->nullable(true);
			$table->string('name')->nullable(true);
			$table->string('company')->nullable(true);
			$table->string('email')->nullable(true);
			$table->string('city')->nullable(true);
			$table->string('course')->nullable(true);
			$table->string('category')->nullable(true);
			$table->string('phone')->nullable(true);
            $table->unsignedBigInteger('statut')->nullable();
            $table->foreign('statut')
                  ->references('id')
                  ->on('statuts')
                  ->onDelete('set null');
            $table->bigInteger('deleted')->default(0);
            $table->dateTime('deleted_at', 0)->nullable(true);
            $table->bigInteger('deleted_by', 0)->nullable(true);
            $table->bigInteger('created_by', 0)->nullable(true);
            $table->bigInteger('updated_by', 0)->nullable(true);
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
        Schema::drop('leads');
    }
}
