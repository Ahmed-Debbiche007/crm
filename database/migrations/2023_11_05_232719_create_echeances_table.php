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
        Schema::create('echeances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('echance_id');
            $table->date('date');
            $table->float('montant');
            $table->boolean('payed');
            $table->string('modalite');
            $table->timestamps();
            $table->foreign('echance_id')->references('id')->on('echances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('echeances');
    }
};
