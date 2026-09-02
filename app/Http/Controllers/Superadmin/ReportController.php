<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Position;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display the reporting dashboard index with filters.
     */
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Assessment::with(['user', 'player', 'finalPosition']);

        if ($startDate) {
            $query->whereDate('assessment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('assessment_date', '<=', $endDate);
        }

        $assessments = $query->orderBy('assessment_date', 'desc')->paginate(15);

        return view('admin.reports.index', compact('assessments', 'startDate', 'endDate'));
    }

    /**
     * Export the filtered reports to PDF (Print-ready HTML).
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Assessment::with(['user', 'player', 'finalPosition']);

        if ($startDate) {
            $query->whereDate('assessment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('assessment_date', '<=', $endDate);
        }

        $assessments = $query->orderBy('assessment_date', 'desc')->get();

        return view('admin.reports.pdf', compact('assessments', 'startDate', 'endDate'));
    }

    /**
     * Export the filtered reports as Excel-compatible CSV via stream download.
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Assessment::with(['user', 'player', 'finalPosition']);

        if ($startDate) {
            $query->whereDate('assessment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('assessment_date', '<=', $endDate);
        }

        $assessments = $query->orderBy('assessment_date', 'desc')->get();

        $filename = 'assessment_report_' . ($startDate ?? 'all') . '_to_' . ($endDate ?? 'all') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($assessments) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel encoding (prevents character encoding bugs in Excel)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'No', 
                'ID Assessment', 
                'Nama Pemain', 
                'Pelatih Pengampu', 
                'Email Pelatih', 
                'Tanggal Assessment', 
                'Total Skor Indikator', 
                'Rekomendasi Posisi', 
                'Kode Posisi'
            ]);

            $no = 1;
            foreach ($assessments as $assessment) {
                fputcsv($file, [
                    $no++,
                    $assessment->id,
                    $assessment->player?->name ?? 'Pemain',
                    $assessment->user?->name ?? '-',
                    $assessment->user?->email ?? '-',
                    $assessment->assessment_date ? $assessment->assessment_date->format('Y-m-d') : '-',
                    $assessment->total_score,
                    $assessment->finalPosition?->name ?? 'Belum Ditentukan',
                    $assessment->finalPosition?->code ?? '-'
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
