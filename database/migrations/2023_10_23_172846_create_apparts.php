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
            $table->integer('type');
            $table->float('surface');
            $table->float('price');
            $table->integer('bs');
            $table->text('comments');
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
