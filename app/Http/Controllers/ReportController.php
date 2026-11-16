<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Services\ReportService;
use Illuminate\View\View;

/**
 * Contrôleur ReportController
 * 
 * Restitution visuelle du rapport de diagnostic et export d'impression PDF.
 */
class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * Affiche le rapport complet de diagnostic avec radar chart et recommandations.
     */
    public function show(string $uuid): View
    {
        $diagnostic = Diagnostic::where('uuid', $uuid)->firstOrFail();
        $reportData = $this->reportService->formatReportData($diagnostic);

        return view('diagnostic.report', $reportData);
    }

    /**
     * Vue d'impression épurée pour export A4 / PDF.
     */
    public function print(string $uuid): View
    {
        $diagnostic = Diagnostic::where('uuid', $uuid)->firstOrFail();
        $reportData = $this->reportService->formatReportData($diagnostic);

        return view('diagnostic.print', $reportData);
    }
}
