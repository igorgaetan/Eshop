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
        Schema::table('factures', function (Blueprint $table) {
            $table->unsignedBigInteger("commande_id")->nullable();
            $table->foreign("commande_id")->references("id")->on("commandes")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {
             // Supprime la contrainte de clé étrangère d'abord
             $table->dropForeign(['commande_id']);
             // Puis supprime la colonne
             $table->dropColumn('commande_id');
        });
    }
};
