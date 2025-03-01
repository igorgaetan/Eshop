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
         DB::statement('ALTER TABLE factures AUTO_INCREMENT = 1000000;');
         DB::statement('ALTER TABLE commandes AUTO_INCREMENT = 1000000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
