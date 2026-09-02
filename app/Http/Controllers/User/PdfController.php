<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Generate print-ready PDF for a specific assessment and download directly.
     */
    public function assessment($id)
    {
        $assessment = Assessment::where('user_id', auth()->id())
            ->with([
                'user.playerProfile',
                'player',
                'testResults.test',
                'scores.indicator',
                'results.position',
                'finalPosition'
            ])
            ->findOrFail($id);

        return view('user.pdf.assessment', compact('assessment'));
    }

    /**
     * Generate print-ready PDF for the user's entire assessment history and download directly.
     */
    public function history()
    {
        $user = auth()->user();

        $assessments = Assessment::where('user_id', $user->id)
            ->with(['player', 'finalPosition'])
            ->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pdf.history', compact('user', 'assessments'));
    }
}
