<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiagnosticRequest;
use App\Models\Diagnostic;
use App\Services\DiagnosticService;
use App\Services\NotificationService;
use App\Services\ReportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Contrôleur DiagnosticController
 * 
 * Gère la vitrine SPESORA GROUP (Douala), le catalogue des prestations,
 * le diagnostic Flash et les actions associées.
 */
class DiagnosticController extends Controller
{
    public function __construct(
        protected DiagnosticService $diagnosticService,
        protected ReportService $reportService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Page d'accueil : Vitrine officielle SPESORA GROUP & Lancement du Diagnostic Flash.
     */
    public function index(): View
    {
        $services = config('spesora.services', []);
        $methodology = config('spesora.methodology_steps', []);
        $values = config('spesora.values', []);
        $references = config('spesora.references', []);
        $markets = config('spesora.target_markets', []);
        $pillars = config('spesora.pillars', []);
        $totalDiagnostics = Diagnostic::count();

        return view('diagnostic.index', compact(
            'services',
            'methodology',
            'values',
            'references',
            'markets',
            'pillars',
            'totalDiagnostics'
        ));
    }

    /**
     * Page dédiée au catalogue complet des offres et prestations.
     */
    public function services(): View
    {
        $services = config('spesora.services', []);
        $methodology = config('spesora.methodology_steps', []);
        $references = config('spesora.references', []);
        $markets = config('spesora.target_markets', []);
        $targets = config('spesora.targets', []);

        return view('diagnostic.services', compact(
            'services',
            'methodology',
            'references',
            'markets',
            'targets'
        ));
    }

    /**
     * Formulaire d'évaluation en ligne.
     * Permet le pré-ciblage d'un objectif selon le CTA d'un service cliqué.
     */
    public function create(Request $request): View
    {
        $pillars = config('spesora.pillars', []);
        $targets = config('spesora.targets', []);
        $preselectedTarget = $request->query('target', '');

        return view('diagnostic.form', compact('pillars', 'targets', 'preselectedTarget'));
    }

    /**
     * Traitement de la soumission du diagnostic.
     */
    public function store(StoreDiagnosticRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $organizationData = [
            'name' => $validated['company_name'],
            'sector' => $validated['sector'],
            'size' => $validated['size'],
            'budget_range' => $validated['budget_range'] ?? 'modere',
            'contact_name' => $validated['contact_name'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
        ];

        $targetObjectifs = $validated['target_objectifs'] ?? [];

        // Extraction des réponses aux questions des 4 piliers
        $answersKeys = [
            'crm_tool', 'erp_billing_tool', 'collab_suite', 'marketing_tools', 'tools_integration',
            'hardware_age', 'network_quality', 'mobility_remote_work', 'servers_infrastructure',
            'backup_policy', 'auth_security', 'endpoint_protection', 'maintenance_support', 'gdpr_compliance',
            'automation_level', 'team_training', 'process_documentation', 'cross_team_collaboration',
        ];

        $answers = [];
        foreach ($answersKeys as $key) {
            $answers[$key] = $validated[$key] ?? '';
        }

        // Création, calcul et persistance dans MySQL spedeck via le service métier
        $diagnostic = $this->diagnosticService->submitDiagnostic(
            organizationData: $organizationData,
            answers: $answers,
            targetObjectifs: $targetObjectifs
        );

        return redirect()->route('diagnostic.report', ['diagnostic' => $diagnostic->uuid])
                         ->with('success', 'Votre diagnostic a été calculé et enregistré dans la base de données avec succès. Un email récapitulatif a été transmis.');
    }

    /**
     * Action d'envoi / renvoi du rapport par email.
     */
    public function sendEmail(Request $request, string $uuid): RedirectResponse
    {
        $diagnostic = Diagnostic::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $sent = $this->notificationService->resendReportEmail($diagnostic, $validated['email']);

        if ($sent) {
            return back()->with('success', "Le rapport a été envoyé avec succès à l'adresse {$validated['email']}.");
        }

        return back()->with('error', "Une erreur est survenue lors de l'envoi de l'email.");
    }

    /**
     * Action pour solliciter un accompagnement auprès des consultants SPESORA GROUP.
     */
    public function requestConsulting(Request $request, string $uuid): RedirectResponse
    {
        $diagnostic = Diagnostic::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'service_interest' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $contactData = [
            'name' => $validated['contact_name'],
            'email' => $validated['contact_email'],
            'phone' => $validated['contact_phone'] ?? null,
            'service_interest' => $validated['service_interest'] ?? 'Diagnostic & Accompagnement Global',
            'message' => $validated['message'] ?? null,
        ];

        $sent = $this->notificationService->sendConsultingRequest($diagnostic, $contactData);

        if ($sent) {
            return back()->with('success', 'Votre demande a bien été transmise à SPESORA GROUP. Un consultant prendra contact avec vous dans les 24h.');
        }

        return back()->with('error', "Une erreur est survenue lors de la transmission de votre demande.");
    }
}
