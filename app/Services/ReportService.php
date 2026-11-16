<?php

namespace App\Services;

use App\Models\Diagnostic;

/**
 * Service ReportService
 * 
 * Module 8 : Génération des rapports.
 * Prépare et structure les indicateurs pour l'affichage Blade et l'export PDF.
 */
class ReportService
{
    /**
     * Formate les données du rapport pour les vues Blade.
     */
    public function formatReportData(Diagnostic $diagnostic): array
    {
        $organization = $diagnostic->organization;
        $targetsConfig = config('spesora.targets', []);

        // Libellés des cibles choisies
        $targetLabels = [];
        foreach ($diagnostic->target_objectifs ?? [] as $tKey) {
            if (isset($targetsConfig[$tKey])) {
                $targetLabels[] = $targetsConfig[$tKey]['label'];
            }
        }
        if (empty($targetLabels)) {
            $targetLabels[] = "Modernisation générale et diagnostic Flash";
        }

        // Préparation des séries Chart.js pour le Radar Chart
        $radarLabels = ['Logiciel & Outils', 'Matériel & Réseau', 'Opérationnel & Sécurité', 'Productivité & Humain'];
        $radarCurrent = [];
        $radarRequired = [];

        $pillarKeys = ['software', 'hardware', 'operational', 'productive'];
        foreach ($pillarKeys as $pKey) {
            $pData = $diagnostic->pillar_scores[$pKey] ?? null;
            $radarCurrent[] = $pData['score'] ?? 50.0;
            $radarRequired[] = $pData['requirement'] ?? 70.0;
        }

        // Recommandations réparties en Quick Wins et Projets Structurants
        $allRecs = $diagnostic->recommendations()->get();
        $quickWins = $allRecs->where('is_quick_win', true)->values();
        $strategicProjects = $allRecs->where('is_quick_win', false)->values();

        return [
            'diagnostic' => $diagnostic,
            'organization' => $organization,
            'target_labels' => $targetLabels,
            'pillar_scores' => $diagnostic->pillar_scores ?? [],
            'radar' => [
                'labels' => $radarLabels,
                'current' => $radarCurrent,
                'required' => $radarRequired,
            ],
            'quick_wins' => $quickWins,
            'strategic_projects' => $strategicProjects,
            'all_recommendations' => $allRecs,
        ];
    }
}
