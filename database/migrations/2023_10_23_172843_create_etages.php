<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('residence_id');
            $table->string('plan')->nullable();
            $table->string('hplan')->nullable();
            $table->string('wplan')->nullable();
            $table->integer('number')->nullable();
            $table->timestamps();
            $table->foreign('residence_id')->references('id')->on('residences');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etages');
    }
};
