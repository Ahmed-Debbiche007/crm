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
            $table->string('type');
            $table->date('date');
            $table->float('amount');
            $table->date('date_avance');
            $table->float('amount_avance');
            $table->boolean('payed');
            $table->timestamps();
            $table->foreign('appart_id')->references('id')->on('apparts');
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
