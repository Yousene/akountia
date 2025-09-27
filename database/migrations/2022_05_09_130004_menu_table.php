<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('titre')->nullable(true);
			$table->string('page')->nullable(true);
			$table->string('parent_menu')->nullable(true);
			$table->string('ordre')->nullable(true);
			$table->integer('ressource')->nullable(true);
			$table->string('statut')->nullable(true);
			$table->string('icon')->nullable(true);
			$table->string('roles')->nullable(true);
			$table->longText('desc')->nullable(true);
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
        Schema::drop('menus');
    }
}
