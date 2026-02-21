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
        Schema::table('annee_scolaires', function (Blueprint $table) {
            $table->date('date_debut')->nullable()->after('libelle');
            $table->date('date_fin')->nullable()->after('date_debut');
            $table->boolean('est_active')->default(false)->after('date_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annee_scolaires', function (Blueprint $table) {
            $table->dropColumn('date_debut', 'date_fin', 'est_active');
        });
    }
};
