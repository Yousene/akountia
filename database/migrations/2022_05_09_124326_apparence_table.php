<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApparenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apparences', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('label')->nullable(true);
			$table->string('title')->nullable(true);
			$table->string('logo_titre')->nullable(true);
			$table->string('layout')->nullable(true);
			$table->string('logo')->nullable(true);
			$table->string('logo_home')->nullable(true);
			$table->string('couleur_header')->nullable(true);
			$table->string('couleur_sidebar')->nullable(true);
			$table->string('couleur_sidebar_logo')->nullable(true);
			$table->string('couleur_menu_actif')->nullable(true);
			$table->string('statut')->nullable(true);

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
        Schema::drop('apparences');
    }
}
