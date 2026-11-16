<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * Modèle Diagnostic
 * 
 * Instance d'un diagnostic Flash réalisé pour une organisation.
 * Module 2 : Gestion des diagnostics.
 * 
 * @property int $id
 * @property string $uuid Identifiant public unique
 * @property int $organization_id
 * @property int|null $questionnaire_id
 * @property string $status Statut (draft, completed, reviewed, archived)
 * @property array $target_objectifs Objectifs business ciblés (analogie fiche de poste)
 * @property float|null $global_score Note globale de maturité (0-100)
 * @property float|null $target_readiness_score Score d'adéquation cible (0-100)
 * @property array|null $pillar_scores Détail des notes et benchmarks par pilier
 * @property string|null $executive_summary Synthèse d'évaluation SPESORA GROUP
 */
class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'organization_id',
        'questionnaire_id',
        'status',
        'target_objectifs',
        'global_score',
        'target_readiness_score',
        'pillar_scores',
        'executive_summary',
    ];

    protected $casts = [
        'target_objectifs' => 'array',
        'pillar_scores' => 'array',
        'global_score' => 'float',
        'target_readiness_score' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($diagnostic) {
            if (empty($diagnostic->uuid)) {
                $diagnostic->uuid = (string) Str::uuid();
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(DiagnosticAnswer::class);
    }

    public function recommendations(): BelongsToMany
    {
        return $this->belongsToMany(Recommendation::class, 'diagnostic_recommendation')
                    ->withPivot(['priority_override', 'is_quick_win'])
                    ->withTimestamps();
    }
}
