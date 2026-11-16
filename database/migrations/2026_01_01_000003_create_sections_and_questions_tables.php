<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sections du questionnaire
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('questionnaire_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('pillar_code', 50)->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        // Questions individuelles
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('pillar_code', 50);
            $table->text('label');
            $table->text('help_text')->nullable();
            $table->integer('order')->default(1);
            $table->decimal('weight', 4, 2)->default(1.00);
            $table->timestamps();
        });

        // Options de réponse prédéfinies avec barème
        Schema::create('answer_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('value_code', 50);
            $table->text('label');
            $table->decimal('score', 5, 2)->default(50.00); // 0 à 100
            $table->string('tag', 50)->nullable();
            $table->string('recommendation_code', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answer_options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('sections');
    }
};
