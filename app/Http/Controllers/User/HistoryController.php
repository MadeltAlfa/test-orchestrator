<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HistoryController extends Controller
{
    /**
     * Display a listing of historical assessments with pagination.
     */
    public function index()
    {
        $user = auth()->user();

        $history = Assessment::where('user_id', $user->id)
            ->with(['finalPosition', 'player'])
            ->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.history.index', compact('history'));
    }

    /**
     * Display the detailed historical record.
     */
    public function show($id)
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

        $rankings = $assessment->results()
            ->with('position')
            ->orderBy('ranking', 'asc')
            ->get();

        return view('user.history.show', compact('assessment', 'rankings'));
    }

    /**
     * Remove the specified assessment history from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $assessment = Assessment::where('user_id', auth()->id())
                ->findOrFail($id);

            $date = $assessment->assessment_date->format('d-m-Y');
            $assessment->delete();

            DB::commit();

            return redirect()
                ->route('user.history.index')
                ->with('success', "Riwayat assessment tanggal {$date} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('User gagal menghapus riwayat assessment: ' . $e->getMessage());

            return redirect()
                ->route('user.history.index')
                ->with('error', 'Terjadi kesalahan saat menghapus riwayat assessment.');
        }
    }
}
