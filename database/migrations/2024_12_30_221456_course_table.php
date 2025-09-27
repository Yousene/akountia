<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categorys')
                  ->onDelete('set null');
            $table->string('name', 250)->nullable(false);
            $table->string('link', 250)->nullable(false)->unique();
			$table->text('short_description')->nullable(true);
			$table->text('description')->nullable(true);
			$table->integer('duration')->nullable(true);
			$table->enum('duration_unit', ['jours', 'heures', 'semaines', 'mois'])->nullable(true);
			$table->text('objectives')->nullable(true);
			$table->text('target_audience')->nullable(true);
			$table->text('prerequisites')->nullable(true);
			$table->text('teaching_methods')->nullable(true);
			$table->string('icon_image')->nullable(true);
			$table->string('sidebar_image')->nullable(true);
			$table->string('description_image')->nullable(true);
			$table->boolean('is_certified')->nullable(true);

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
        Schema::dropIfExists('courses');
    }
}
