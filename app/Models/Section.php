<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle Section
 * 
 * Regroupe les questions par thématique dans le questionnaire.
 */
class Section extends Model
{
    protected $fillable = [
        'questionnaire_id',
        'title',
        'subtitle',
        'pillar_code',
        'order',
    ];

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}
