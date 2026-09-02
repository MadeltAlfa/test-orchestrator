<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Support\Collection;

class PdfService
{
    /**
     * Generate print-ready HTML for a specific assessment.
     */
    public function generateAssessmentPdf(Assessment $assessment): string
    {
        $assessment->load([
            'user.playerProfile',
            'testResults.test',
            'scores.indicator',
            'results.position',
            'finalPosition'
        ]);

        return view('user.pdf.assessment', compact('assessment'))->render();
    }

    /**
     * Generate print-ready HTML for user assessment history.
     *
     * @param User $user
     * @param Collection<int, Assessment> $assessments
     */
    public function generateHistoryPdf(User $user, Collection $assessments): string
    {
        $user->load('playerProfile');

        return view('user.pdf.history', compact('user', 'assessments'))->render();
    }
}
