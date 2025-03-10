<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {

            $table->id("id");
            $table->decimal("montant", 20, 2, true);
            $table->decimal("montantLivraison", 10, 2)->nullable();
            
            $table->string("nomClient", 30);
            $table->string("mobile", 20);
            $table->text("addresse")->nullable();
            $table->text("commentaire")->nullable();
            $table->smallInteger('livrer')->default(false);
            $table->decimal("avance", 10, 2, true)->default(0);
            $table->decimal("remise", 4, 2, true)->default(0);
            $table->smallInteger('type')->default(0);

            $table->unsignedBigInteger("ville_id")->nullable();
            $table->foreign("ville_id")->references("id")->on("villes")->nullOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
