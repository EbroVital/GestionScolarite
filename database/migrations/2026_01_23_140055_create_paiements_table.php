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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->text('observation')->nullable();
            $table->string('reference_transaction')->nullable();
            $table->foreignId('type_paiement_id')->constrained('type_paiements')->onUpdate('cascade');
            $table->foreignId('eleve_id')->constrained('eleves')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
