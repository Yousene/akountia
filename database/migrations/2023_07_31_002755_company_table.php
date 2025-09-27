<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name')->nullable(true);
			$table->string('short_name')->nullable(true);
			$table->string('type')->nullable(true);
			$table->string('registration_number')->nullable(true);
			$table->string('tax_id_number')->nullable(true);
			$table->string('vat_id_number')->nullable(true);
			$table->string('fiscal_year')->nullable(true);
			$table->string('incorporation_date')->nullable(true);
			$table->string('legal_structure')->nullable(true);
			$table->string('sector')->nullable(true);
			$table->string('industry')->nullable(true);
			$table->longText('description')->nullable(true);
			$table->string('active_status')->nullable(true);
			$table->string('ice_number')->nullable(true);
			$table->string('patente_number')->nullable(true);
			$table->string('cnss_number')->nullable(true);
			$table->string('legal_representative')->nullable(true);
			$table->string('representative_position')->nullable(true);
			$table->string('representative_phone')->nullable(true);
			$table->string('representative_email')->nullable(true);
			$table->string('email')->nullable(true);
			$table->string('phone_number')->nullable(true);
			$table->string('fax_number')->nullable(true);
			$table->string('physical_address')->nullable(true);
			$table->string('postal_address')->nullable(true);
			$table->string('city')->nullable(true);
			$table->string('region')->nullable(true);
			$table->string('postal_code')->nullable(true);
			$table->string('country')->nullable(true);
			$table->string('website')->nullable(true);
			$table->string('logo')->nullable(true);

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
        Schema::drop('companys');
    }
}
