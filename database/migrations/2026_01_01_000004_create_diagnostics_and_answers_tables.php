<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Diagnostics
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('questionnaire_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 30)->default('completed'); // draft, completed, reviewed, archived
            $table->json('target_objectifs')->nullable();
            $table->decimal('global_score', 5, 2)->nullable();
            $table->decimal('target_readiness_score', 5, 2)->nullable();
            $table->json('pillar_scores')->nullable();
            $table->text('executive_summary')->nullable();
            $table->timestamps();
        });

        // Réponses détaillées apportées
        Schema::create('diagnostic_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostic_id')->constrained()->cascadeOnDelete();
            $table->string('question_code', 50)->index();
            $table->string('pillar_code', 50)->index();
            $table->string('selected_value');
            $table->decimal('score_obtained', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnostic_answers');
        Schema::dropIfExists('diagnostics');
    }
};
