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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('purchase_date');
            $table->string('amount_paid');
            $table->string('first_ref')->nullable();
            $table->string('second_ref')->nullable();
            $table->string('direct_ref')->nullable();
            $table->string('consultant_id')->nullable();
            $table->unsignedBigInteger('property_id'); // Foreign key column
            $table->foreign('property_id')->references('id')->on('properties');

            $table->unsignedBigInteger('client_id'); // Foreign key column
            $table->foreign('client_id')->references('id')->on('clients');

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
        Schema::dropIfExists('buyers');
    }
};
