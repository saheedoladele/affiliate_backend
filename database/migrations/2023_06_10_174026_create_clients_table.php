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
        Schema::create('clients', function (Blueprint $table) {
            $table->id()->onDelete('cascade');
            $table->string('client_name');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->bigInteger('amount_paid')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
