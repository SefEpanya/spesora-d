<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request : StoreDiagnosticRequest
 * 
 * Sécurité & Validation stricte côté serveur des réponses au diagnostic.
 */
class StoreDiagnosticRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Organisation
            'company_name' => 'required|string|max:255',
            'sector' => 'required|string|max:50',
            'size' => 'required|in:tpe,pme,eti,grande',
            'budget_range' => 'nullable|string|in:limite,modere,confortable',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:30',

            // Objectifs stratégiques ciblés (multi-select)
            'target_objectifs' => 'nullable|array',
            'target_objectifs.*' => 'string',

            // Pilier Logiciel
            'crm_tool' => 'required|string',
            'erp_billing_tool' => 'required|string',
            'collab_suite' => 'required|string',
            'marketing_tools' => 'required|string',
            'tools_integration' => 'required|string',

            // Pilier Matériel
            'hardware_age' => 'required|string',
            'network_quality' => 'required|string',
            'mobility_remote_work' => 'required|string',
            'servers_infrastructure' => 'required|string',

            // Pilier Opérationnel
            'backup_policy' => 'required|string',
            'auth_security' => 'required|string',
            'endpoint_protection' => 'required|string',
            'maintenance_support' => 'required|string',
            'gdpr_compliance' => 'required|string',

            // Pilier Productif
            'automation_level' => 'required|string',
            'team_training' => 'required|string',
            'process_documentation' => 'required|string',
            'cross_team_collaboration' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => "Le nom de l'organisation est obligatoire.",
            'sector.required' => "Veuillez sélectionner un secteur d'activité.",
            'size.required' => "Veuillez préciser la taille de votre organisation.",
        ];
    }
}
