<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle AnswerOption
 * 
 * Option de réponse prédéfinie avec sa note associée (0-100)
 * et le code de déclenchement d'une éventuelle recommandation.
 */
class AnswerOption extends Model
{
    protected $fillable = [
        'question_id',
        'value_code',
        'label',
        'score',
        'tag',
        'recommendation_code',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
