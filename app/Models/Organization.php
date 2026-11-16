<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modèle Organization
 * 
 * Représente l'entreprise ou l'institution auditée.
 * Module 1 : Gestion des organisations.
 * 
 * @property int $id
 * @property string $name Nom de l'organisation
 * @property string $sector Secteur d'activité (commerce, services, industrie, sante, etc.)
 * @property string $size Tranche d'effectif (tpe, pme, eti, grande)
 * @property string|null $contact_name Nom et prénom du contact référent
 * @property string|null $contact_email Email professionnel
 * @property string|null $contact_phone Numéro de téléphone
 * @property string|null $budget_range Capacité d'investissement (limite, modere, confortable)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sector',
        'size',
        'contact_name',
        'contact_email',
        'contact_phone',
        'budget_range',
    ];

    /**
     * Un client / organisation peut réaliser plusieurs diagnostics dans le temps
     * pour mesurer son évolution de maturité.
     */
    public function diagnostics(): HasMany
    {
        return $this->hasMany(Diagnostic::class);
    }
}
