<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle Question
 * 
 * Module 5 : Gestion des questions et réponses.
 */
class Question extends Model
{
    protected $fillable = [
        'section_id',
        'code',
        'pillar_code',
        'label',
        'help_text',
        'order',
        'weight',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(AnswerOption::class)->orderBy('score', 'asc');
    }
}
