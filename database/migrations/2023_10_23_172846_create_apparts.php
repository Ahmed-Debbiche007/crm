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
        Schema::create('apparts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('etage_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->integer('type')->nullable();
            $table->float('surface')->nullable();
            $table->float('price')->nullable();
            $table->string('x')->nullable();
            $table->string('y')->nullable();
            $table->integer('bs')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->foreign('etage_id')->references('id')->on('etages');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apparts');
    }
};
