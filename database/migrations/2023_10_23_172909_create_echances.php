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
        Schema::create('echances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appart_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->date('date');
            $table->date('date_avance');
            $table->float('amount_avance');
            $table->string('preuve_avance')->nullable();
            $table->string('promesse')->nullable();
            $table->date('date_promesse_livre')->nullable();
            $table->date('date_promesse_legal')->nullable();
            $table->string('contrat')->nullable();
            $table->date('date_contrat_livre')->nullable();
            $table->date('date_contrat_enregistre')->nullable();
            $table->timestamps();
            $table->foreign('appart_id')->references('id')->on('apparts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('echances');
    }
};
