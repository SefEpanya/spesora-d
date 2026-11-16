<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle DiagnosticAnswer
 * 
 * Enregistrement de la réponse fournie à une question lors d'un diagnostic.
 */
class DiagnosticAnswer extends Model
{
    protected $fillable = [
        'diagnostic_id',
        'question_code',
        'pillar_code',
        'selected_value',
        'score_obtained',
    ];

    protected $casts = [
        'score_obtained' => 'float',
    ];

    public function diagnostic(): BelongsTo
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
