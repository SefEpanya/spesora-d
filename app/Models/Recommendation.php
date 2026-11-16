<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modèle Recommendation
 * 
 * Fiche d'action prescriptive recommandée par SPESORA GROUP.
 * Module 8 : Génération des rapports et identification des besoins.
 * 
 * @property int $id
 * @property string $code Code unique (ex: CRM_MIGRATION, MFA_DEPLOYMENT, BACKUP_321)
 * @property string $pillar_code Pilier associé (software, hardware, operational, productive)
 * @property string $title Titre de l'action recommandée
 * @property string $diagnostic_text Constat / vulnérabilité identifiée
 * @property string $action_plan Démarche concrète d'amélioration
 * @property array $suggested_tools Outils et solutions recommandées
 * @property string $priority Priorité standard (Critique, Élevée, Moyenne)
 * @property string $effort_level Délai / effort (Quick Win 1-2 sem, Moyen terme 1-3 mois, Structurant 3-6 mois)
 * @property bool $is_quick_win Vrai si action rapide à fort ROI
 * @property string|null $impact_target_template Explication de l'impact sur l'objectif cible
 */
class Recommendation extends Model
{
    protected $fillable = [
        'code',
        'pillar_code',
        'title',
        'diagnostic_text',
        'action_plan',
        'suggested_tools',
        'priority',
        'effort_level',
        'is_quick_win',
        'impact_target_template',
    ];

    protected $casts = [
        'suggested_tools' => 'array',
        'is_quick_win' => 'boolean',
    ];

    public function diagnostics(): BelongsToMany
    {
        return $this->belongsToMany(Diagnostic::class, 'diagnostic_recommendation');
    }
}
