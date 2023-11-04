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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->float('sonede')->nullable();
            $table->float('syndic')->nullable();
            $table->float('avocat')->nullable();
            $table->float('contrat')->nullable();
            $table->float('foncier')->nullable();
            $table->unsignedBigInteger('appart_id');
            $table->timestamps();
            $table->foreign('appart_id')->references('id')->on('apparts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
