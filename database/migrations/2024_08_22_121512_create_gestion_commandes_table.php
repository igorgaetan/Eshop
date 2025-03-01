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
        Schema::create('gestion_commandes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("commande_id")->nullable();
            $table->foreign("commande_id")->references("id")->on("commandes")->onDelete("cascade");

            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->nullOnDelete();

            $table->smallInteger('etat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_commandes');
    }
};
