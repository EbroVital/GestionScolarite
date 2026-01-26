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
        Schema::create('recus', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
             $table->foreignId('paiement_id')->constrained('paiements')->onDelete('cascade');
            $table->date('date_emission');
            $table->string('numero_recu')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};
