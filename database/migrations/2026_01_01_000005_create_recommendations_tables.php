<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Référentiel des recommandations / fiches actions SPESORA GROUP
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('pillar_code', 50)->index();
            $table->string('title');
            $table->text('diagnostic_text');
            $table->text('action_plan');
            $table->json('suggested_tools')->nullable();
            $table->string('priority', 30)->default('Élevée'); // Critique, Élevée, Moyenne
            $table->string('effort_level', 50)->default('Moyen terme'); // Quick Win, Moyen terme, Structurant
            $table->boolean('is_quick_win')->default(false);
            $table->text('impact_target_template')->nullable();
            $table->timestamps();
        });

        // Table pivot diagnostic <-> recommendation
        Schema::create('diagnostic_recommendation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recommendation_id')->constrained()->cascadeOnDelete();
            $table->string('priority_override', 30)->nullable();
            $table->boolean('is_quick_win')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnostic_recommendation');
        Schema::dropIfExists('recommendations');
    }
};
