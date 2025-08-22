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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->unsignedBigInteger('id_adherent');
            $table->unsignedBigInteger('id_livre');
            $table->date('date_reservation');
            $table->string('status');
            $table->foreign('id_adherent')->references('id_adherent')->on('adherents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_livre')->references('id_livre')->on('livres')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
