<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle Questionnaire
 * 
 * Module 4 : Gestion des questionnaires.
 * Permet d'administrer des questionnaires évolutifs selon la version du diagnostic.
 */
class Questionnaire extends Model
{
    protected $fillable = [
        'title',
        'code',
        'description',
        'version',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function diagnostics(): HasMany
    {
        return $this->hasMany(Diagnostic::class);
    }
}
