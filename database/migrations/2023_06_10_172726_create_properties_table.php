<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_name');
            $table->longText('location');
            $table->longText('description');
            $table->string('actual_price');
            $table->string('promo_price');
            $table->string('developmental_levy');
            $table->string('survey_price');
            $table->string('deed_of_assignment')->nullable();
            $table->string('c_of_o');
            $table->string('promo_details');
            $table->string('property_images')->nullable();
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
        Schema::dropIfExists('properties');
    }
};
