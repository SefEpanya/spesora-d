<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle Framework
 * 
 * Référentiel d'évaluation (piliers méthodologiques SPESORA GROUP).
 * Module 3 : Gestion des référentiels d'évaluation.
 * 
 * @property int $id
 * @property string $code Code unique (software, hardware, operational, productive)
 * @property string $name Libellé de l'axe d'évaluation
 * @property string|null $description Explication méthodologique
 * @property string|null $icon Classe d'icône Bootstrap
 * @property float $default_weight Pondération par défaut dans la note globale
 */
class Framework extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'icon',
        'default_weight',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'framework_code', 'code');
    }
}
