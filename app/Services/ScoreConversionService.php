<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SkillTest;
use App\Models\TestNorm;

class ScoreConversionService
{
    /**
     * Cari norma yang cocok untuk hasil tes tertentu.
     *
     * @param SkillTest $test
     * @param float $value
     * @return TestNorm|null
     */
    public function findNorm(SkillTest $test, float $value): ?TestNorm
    {
        // Gunakan collection untuk mendukung lazy-loading / eager-loading yang efisien
        return $test->norms->first(function (TestNorm $norm) use ($value) {
            return $norm->matches($value);
        });
    }

    /**
     * Konversi nilai hasil tes mentah menjadi skor terstandarisasi dan kategori norma.
     *
     * @param SkillTest $test
     * @param float $value
     * @return array{score: int, category: string, norm: ?TestNorm}
     */
    public function convert(SkillTest $test, float $value): array
    {
        $norm = $this->findNorm($test, $value);

        return [
            'score' => $norm !== null ? (int) $norm->score : 0,
            'category' => $norm !== null ? $norm->category : 'Sangat Kurang',
            'norm' => $norm,
        ];
    }
}
