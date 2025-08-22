<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->enum('statut', ['en_cours', 'retourne'])->default('en_cours')->after('date_retour_effectif');
        });
    }

    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};
