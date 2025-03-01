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
        Schema::table('commandes', function (Blueprint $table) {
            $table->unsignedInteger("client_carte_matr")->nullable();
            $table->foreign("client_carte_matr")->references("matr")->on("client_cartes")->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            // Supprime la contrainte de clé étrangère d'abord
            $table->dropForeign(['client_carte_matr']);
            // Puis supprime la colonne
            $table->dropColumn('client_carte_matr');
        });
    }
};
