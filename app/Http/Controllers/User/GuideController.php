<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TestGuide;
use App\Models\SkillTest;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Display a paginated listing of available test guides.
     */
    public function index()
    {
        $guides = TestGuide::with(['test'])
            ->orderBy('title', 'asc')
            ->paginate(10);

        return view('user.guides.index', compact('guides'));
    }

    /**
     * Display a specific test guide including sections (how-to instructions) and norms.
     */
    public function show($id)
    {
        // Eager load sections in order, and the associated skill test with its scoring norms
        $guide = TestGuide::with([
            'test.norms' => function ($query) {
                $query->orderBy('score', 'desc');
            },
            'sections' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }
        ])->findOrFail($id);

        return view('user.guides.show', compact('guide'));
    }
}
