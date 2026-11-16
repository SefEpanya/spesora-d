<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;
use App\Models\Organization;
use App\Mail\DiagnosticCompletedClientMail;
use App\Mail\DiagnosticCompletedAdminMail;
use App\Mail\ConsultingRequestAdminMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Contrôleur DashboardController (Admin)
 * 
 * Module 10 : Administration et statistiques pour les consultants SPESORA GROUP.
 */
class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $totalDiagnostics = Diagnostic::count();
        $totalOrganizations = Organization::count();
        $averageMaturity = round(Diagnostic::avg('global_score') ?? 0, 1);
        $averageReadiness = round(Diagnostic::avg('target_readiness_score') ?? 0, 1);

        $query = Diagnostic::with('organization')->latest();

        if ($search) {
            $query->whereHas('organization', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('sector', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $recentDiagnostics = $query->paginate(15)->withQueryString();

        return view('admin.dashboard', compact(
            'totalDiagnostics',
            'totalOrganizations',
            'averageMaturity',
            'averageReadiness',
            'recentDiagnostics',
            'search',
            'status'
        ));
    }

    /**
     * Supprimer un diagnostic.
     */
    public function destroy(string $uuid): RedirectResponse
    {
        $diagnostic = Diagnostic::where('uuid', $uuid)->firstOrFail();
        $diagnostic->delete();

        return back()->with('success', 'Diagnostic supprimé avec succès.');
    }

    /**
     * Prévisualisation des emails dans le navigateur pour contrôle visuel.
     */
    public function previewMail(string $type, ?string $uuid = null)
    {
        $diagnostic = $uuid ? Diagnostic::where('uuid', $uuid)->first() : Diagnostic::latest()->first();

        if (!$diagnostic) {
            return "Aucun diagnostic disponible pour prévisualiser l'email. Veuillez d'abord réaliser un diagnostic.";
        }

        return match ($type) {
            'client' => new DiagnosticCompletedClientMail($diagnostic),
            'admin' => new DiagnosticCompletedAdminMail($diagnostic),
            'consulting' => new ConsultingRequestAdminMail($diagnostic, [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@entreprise.fr',
                'phone' => '+33 6 12 34 56 78',
                'service_interest' => 'Cybersécurité, Résilience & Sauvegardes',
                'message' => 'Nous souhaitons revoir notre infrastructure et mettre en place un plan de reprise d\'activité.',
            ]),
            default => abort(404, "Type d'email inconnu"),
        };
    }
}
