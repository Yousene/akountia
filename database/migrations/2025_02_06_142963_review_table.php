<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name')->nullable(true);
			$table->string('company')->nullable(true);
            $table->string('company_url')->nullable(true);
			$table->string('position')->nullable(true);
            $table->decimal('rating', 2, 1)->nullable(true);  // Au lieu de integer
            $table->boolean('validation')->default(false);
			$table->string('comment')->nullable(true);
			$table->enum('genre', ['Homme', 'Femme'])->nullable(true);
			$table->string('picture')->default('default-male.png');
			$table->unsignedBigInteger('course_id')->nullable(true);
			$table->foreign('course_id')
				  ->references('id')
				  ->on('courses')
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
        Schema::drop('reviews');
    }
}
