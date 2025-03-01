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
        Schema::create('tontines', function (Blueprint $table) {
            $table->id();
            $table->decimal("montant", 10, 2,true);
            $table->text("commentaire")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users");

            $table->tinyInteger("validite");
            $table->unsignedInteger("client_carte_matr")->nullable();
            $table->foreign("client_carte_matr")->references("matr")->on("client_cartes")->cascadeOnDelete();
            $table->tinyInteger("action");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontines');
    }
};
