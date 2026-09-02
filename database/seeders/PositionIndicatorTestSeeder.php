<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Indicator;
use App\Models\SkillTest;
use App\Models\PositionIndicator;
use App\Models\IndicatorTest;
use App\Models\TestNorm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PositionIndicatorTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define Tests to create
        $testsData = [
            'Small-Sided Games Composure' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Small-Sided Games' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Loughborough Soccer Passing Test (LSPT)' => ['unit' => 'detik', 'input_type' => 'time', 'use_stopwatch' => true, 'use_increment' => false],
            'Vertical Jump' => ['unit' => 'cm', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => false],
            'Squat Jump' => ['unit' => 'kali', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Wall Ball Test' => ['unit' => 'kali', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Target-Based Heading Test' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Small-Sided Game Interception' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Small-Sided Game Marking' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Test Sprint Acceleration' => ['unit' => 'detik', 'input_type' => 'time', 'use_stopwatch' => true, 'use_increment' => false],
            '40-m sprint test' => ['unit' => 'detik', 'input_type' => 'time', 'use_stopwatch' => true, 'use_increment' => false],
            'Bleep Test' => ['unit' => 'level', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => false],
            'Juggling Test' => ['unit' => 'kali', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Shooting Test' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Short Pass Test' => ['unit' => 'kali', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'T-Test' => ['unit' => 'detik', 'input_type' => 'time', 'use_stopwatch' => true, 'use_increment' => false],
            'Crossing Test' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
            'Dribbling Test' => ['unit' => 'detik', 'input_type' => 'time', 'use_stopwatch' => true, 'use_increment' => false],
            'Small-Sided Game Positioning' => ['unit' => 'skor', 'input_type' => 'number', 'use_stopwatch' => false, 'use_increment' => true],
        ];

        $tests = [];
        foreach ($testsData as $name => $meta) {
            $test = SkillTest::updateOrCreate(
                ['name' => $name],
                [
                    'description' => "Panduan dan deskripsi untuk tes keahlian: {$name}.",
                    'unit' => $meta['unit'],
                    'input_type' => $meta['input_type'],
                    'use_stopwatch' => $meta['use_stopwatch'],
                    'use_increment' => $meta['use_increment'],
                ]
            );
            $tests[$name] = $test;

            // Clear existing norms to ensure a clean slate and consistent scoring scale
            $test->norms()->delete();

            if ($name === 'Test Sprint Acceleration') {
                // Specific norms for Test Sprint Acceleration (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => null, 'max_value' => 3.20, 'score' => 10, 'operator' => 'less_than']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 3.20, 'max_value' => 3.55, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 3.56, 'max_value' => 3.75, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 3.76, 'max_value' => 4.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 4.01, 'max_value' => 4.25, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 4.26, 'max_value' => 4.50, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 4.51, 'max_value' => 4.75, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 4.76, 'max_value' => 5.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 5.01, 'max_value' => 5.25, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 5.25, 'max_value' => null, 'score' => 1, 'operator' => 'greater_than']);
            } elseif ($name === 'T-Test') {
                // Specific norms for T-Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => null, 'max_value' => 9.50, 'score' => 10, 'operator' => 'less_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 9.51, 'max_value' => 10.20, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 10.21, 'max_value' => 10.50, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 10.51, 'max_value' => 11.20, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.21, 'max_value' => 11.50, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.51, 'max_value' => 12.20, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 12.21, 'max_value' => 12.50, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 12.51, 'max_value' => 13.20, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 13.21, 'max_value' => 13.50, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 13.50, 'max_value' => null, 'score' => 1, 'operator' => 'greater_than']);
            } elseif ($name === 'Juggling Test') {
                // Specific norms for Juggling Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 100.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 91.00, 'max_value' => 100.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 81.00, 'max_value' => 90.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 71.00, 'max_value' => 80.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 61.00, 'max_value' => 70.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 51.00, 'max_value' => 60.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 41.00, 'max_value' => 50.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 31.00, 'max_value' => 40.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 21.00, 'max_value' => 30.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 20.00, 'score' => 1, 'operator' => 'less_equal']);
            } elseif ($name === 'Small-Sided Games Composure') {
                // Specific norms for Small-Sided Games Composure (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 19.00, 'max_value' => 20.00, 'score' => 10, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 17.00, 'max_value' => 18.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 15.00, 'max_value' => 16.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 13.00, 'max_value' => 14.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.00, 'max_value' => 12.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 9.00, 'max_value' => 10.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 7.00, 'max_value' => 8.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 5.00, 'max_value' => 6.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 3.00, 'max_value' => 4.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 1.00, 'max_value' => 2.00, 'score' => 1, 'operator' => 'between']);
            } elseif ($name === 'Crossing Test') {
                // Specific norms for Crossing Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 15.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 14.00, 'max_value' => 14.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 13.00, 'max_value' => 13.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 12.00, 'max_value' => 12.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.00, 'max_value' => 11.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 10.00, 'max_value' => 10.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 7.00, 'max_value' => 7.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 7.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Dribbling Test') {
                // Specific norms for Dribbling Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => null, 'max_value' => 14.24, 'score' => 10, 'operator' => 'less_than']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 14.24, 'max_value' => 15.23, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 15.24, 'max_value' => 16.23, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 16.24, 'max_value' => 17.23, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 17.24, 'max_value' => 18.23, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 18.24, 'max_value' => 19.23, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 19.24, 'max_value' => 20.23, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 20.24, 'max_value' => 21.23, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 21.24, 'max_value' => 22.23, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 22.23, 'max_value' => null, 'score' => 1, 'operator' => 'greater_than']);
            } elseif ($name === 'Target-Based Heading Test') {
                // Specific norms for Target-Based Heading Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 10.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 7.00, 'max_value' => 7.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 6.00, 'max_value' => 6.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 5.00, 'max_value' => 5.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 4.00, 'max_value' => 4.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 3.00, 'max_value' => 3.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 2.00, 'max_value' => 2.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 2.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Small-Sided Game Interception') {
                // Specific norms for Small-Sided Game Interception (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 19.00, 'max_value' => 20.00, 'score' => 10, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 17.00, 'max_value' => 18.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 15.00, 'max_value' => 16.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 13.00, 'max_value' => 14.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.00, 'max_value' => 12.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 9.00, 'max_value' => 10.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 7.00, 'max_value' => 8.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 5.00, 'max_value' => 6.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 3.00, 'max_value' => 4.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 1.00, 'max_value' => 2.00, 'score' => 1, 'operator' => 'between']);
            } elseif ($name === 'Vertical Jump') {
                // Specific norms for Vertical Jump (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 70.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_than']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 63.00, 'max_value' => 69.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 56.00, 'max_value' => 62.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 49.00, 'max_value' => 55.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 42.00, 'max_value' => 48.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 35.00, 'max_value' => 41.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 28.00, 'max_value' => 34.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 21.00, 'max_value' => 27.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 14.00, 'max_value' => 20.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 14.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Loughborough Soccer Passing Test (LSPT)') {
                // Specific norms for LSPT (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 12.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 11.00, 'max_value' => 11.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 10.00, 'max_value' => 10.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 7.00, 'max_value' => 7.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 6.00, 'max_value' => 6.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 5.00, 'max_value' => 5.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 4.00, 'max_value' => 4.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 4.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Shooting Test') {
                // Specific norms for Shooting Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 29.00, 'max_value' => 30.00, 'score' => 10, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 27.00, 'max_value' => 28.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 25.00, 'max_value' => 26.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 23.00, 'max_value' => 24.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 21.00, 'max_value' => 22.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 19.00, 'max_value' => 20.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 17.00, 'max_value' => 18.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 15.00, 'max_value' => 16.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 13.00, 'max_value' => 14.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 13.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Small-Sided Game Marking') {
                // Specific norms for Small-Sided Game Marking (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 10.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 7.00, 'max_value' => 7.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 6.00, 'max_value' => 6.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 5.00, 'max_value' => 5.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 4.00, 'max_value' => 4.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 3.00, 'max_value' => 3.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 2.00, 'max_value' => 2.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 2.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Small-Sided Game Positioning') {
                // Specific norms for Small-Sided Game Positioning (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 19.00, 'max_value' => 20.00, 'score' => 10, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 17.00, 'max_value' => 18.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 15.00, 'max_value' => 16.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 13.00, 'max_value' => 14.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.00, 'max_value' => 12.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 9.00, 'max_value' => 10.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 7.00, 'max_value' => 8.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 5.00, 'max_value' => 6.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 3.00, 'max_value' => 4.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 1.00, 'max_value' => 2.00, 'score' => 1, 'operator' => 'between']);
            } elseif ($name === 'Wall Ball Test') {
                // Specific norms for Wall Ball Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 10.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 7.00, 'max_value' => 7.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 6.00, 'max_value' => 6.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 5.00, 'max_value' => 5.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 4.00, 'max_value' => 4.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 3.00, 'max_value' => 3.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 2.00, 'max_value' => 2.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 2.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Short Pass Test') {
                // Specific norms for Short Pass Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 16.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_equal']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 15.00, 'max_value' => 15.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 14.00, 'max_value' => 14.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 13.00, 'max_value' => 13.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 12.00, 'max_value' => 12.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 11.00, 'max_value' => 11.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 10.00, 'max_value' => 10.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 8.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === '40-m sprint test') {
                // Specific norms for 40-m sprint test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => null, 'max_value' => 5.50, 'score' => 10, 'operator' => 'less_than']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 5.50, 'max_value' => 6.09, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 6.10, 'max_value' => 6.29, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 6.30, 'max_value' => 6.49, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 6.50, 'max_value' => 7.09, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 7.10, 'max_value' => 7.29, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 7.30, 'max_value' => 7.49, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 7.50, 'max_value' => 8.09, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 8.10, 'max_value' => 8.29, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 8.29, 'max_value' => null, 'score' => 1, 'operator' => 'greater_than']);
            } elseif ($name === 'Bleep Test') {
                // Specific norms for Bleep Test (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 12.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_than']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 12.00, 'max_value' => 12.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 11.00, 'max_value' => 11.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 10.00, 'max_value' => 10.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 9.00, 'max_value' => 9.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 8.00, 'max_value' => 8.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 7.00, 'max_value' => 7.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 6.00, 'max_value' => 6.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 5.00, 'max_value' => 5.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 5.00, 'score' => 1, 'operator' => 'less_than']);
            } elseif ($name === 'Squat Jump') {
                // Specific norms for Squat Jump (scale 1-10)
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 22.00, 'max_value' => null, 'score' => 10, 'operator' => 'greater_than']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 21.00, 'max_value' => 22.00, 'score' => 9, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 19.00, 'max_value' => 20.00, 'score' => 8, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 17.00, 'max_value' => 18.00, 'score' => 7, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 15.00, 'max_value' => 16.00, 'score' => 6, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 13.00, 'max_value' => 14.00, 'score' => 5, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 11.00, 'max_value' => 12.00, 'score' => 4, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 9.00, 'max_value' => 10.00, 'score' => 3, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => 7.00, 'max_value' => 8.00, 'score' => 2, 'operator' => 'between']);
                TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Kurang', 'min_value' => null, 'max_value' => 7.00, 'score' => 1, 'operator' => 'less_than']);
            } else {
                if ($meta['input_type'] === 'time') {
                    // Time-based (lower is better, e.g. sprint) - scaled to 1-10
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 0.00, 'max_value' => 5.00, 'score' => 10, 'operator' => 'between']);
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 5.01, 'max_value' => 7.00, 'score' => 8, 'operator' => 'between']);
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 7.01, 'max_value' => 9.00, 'score' => 6, 'operator' => 'between']);
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 9.01, 'max_value' => 999.00, 'score' => 4, 'operator' => 'between']);
                } else {
                    // Number-based (higher is better, e.g. jumps, scores) - scaled to 1-10
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Sangat Baik', 'min_value' => 80.00, 'max_value' => 999.00, 'score' => 10, 'operator' => 'greater_equal']);
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Baik', 'min_value' => 60.00, 'max_value' => 79.99, 'score' => 8, 'operator' => 'between']);
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Sedang', 'min_value' => 40.00, 'max_value' => 59.99, 'score' => 6, 'operator' => 'between']);
                    TestNorm::create(['test_id' => $test->id, 'category' => 'Kurang', 'min_value' => 0.00, 'max_value' => 39.99, 'score' => 4, 'operator' => 'between']);
                }
            }
        }

        // 2. Define Indicators to create
        $indicatorsData = [
            'Composure' => 'CMP',
            'Long Pass' => 'LPS',
            'Jumping' => 'JMP',
            'Strength' => 'STR',
            'Reaction' => 'REA',
            'Heading' => 'HDG',
            'Interceptions' => 'INT',
            'Marking' => 'MRK',
            'Acceleration' => 'ACC',
            'Speed Sprint' => 'SPD',
            'Stamina' => 'STA',
            'Ball Control' => 'BCL',
            'Long Shoot' => 'LST',
            'Short Pass' => 'SPS',
            'Agility' => 'AGL',
            'Crossing' => 'CRS',
            'Dribble' => 'DRB',
            'Positioning' => 'POS',
        ];

        $indicators = [];
        foreach ($indicatorsData as $name => $code) {
            $indicators[$name] = Indicator::updateOrCreate(
                ['name' => $name],
                [
                    'code' => $code,
                    'description' => "Indikator kemampuan pemain: {$name}.",
                    'scoring_note' => 'Dinilai berdasarkan tes fisik dan keahlian sepak bola.',
                ]
            );
        }

        // 3. Define Positions, their Indicators, and weight percentages
        $positionsData = [
            'GK' => [
                'name' => 'Goalkeeper',
                'description' => 'Penjaga gawang yang bertugas menepis bola dan menjaga keperawanan gawang.',
                'indicators' => [
                    'Composure' => 20.00,
                    'Long Pass' => 20.00,
                    'Jumping' => 20.00,
                    'Strength' => 20.00,
                    'Reaction' => 20.00,
                ],
            ],
            'CB' => [
                'name' => 'Centre Back',
                'description' => 'Bek tengah tangguh pelindung area pertahanan pertahanan utama.',
                'indicators' => [
                    'Heading' => 20.00,
                    'Interceptions' => 20.00,
                    'Jumping' => 20.00,
                    'Marking' => 20.00,
                    'Strength' => 20.00,
                ],
            ],
            'DL/DR' => [
                'name' => 'Defender Left/Right',
                'description' => 'Bek sayap kiri/kanan pembantu pertahanan dan penyerangan sayap.',
                'indicators' => [
                    'Acceleration' => 25.00,
                    'Long Pass' => 25.00,
                    'Speed Sprint' => 25.00,
                    'Stamina' => 25.00,
                ],
            ],
            'MC' => [
                'name' => 'Midfielder Centre',
                'description' => 'Gelandang tengah pengatur ritme permainan dan penyeimbang tim.',
                'indicators' => [
                    'Ball Control' => 20.00,
                    'Long Pass' => 20.00,
                    'Long Shoot' => 20.00,
                    'Short Pass' => 20.00,
                    'Stamina' => 20.00,
                ],
            ],
            'ML/MR' => [
                'name' => 'Midfielder Left/Right',
                'description' => 'Gelandang sayap kiri/kanan pengantar umpan silang dan transisi cepat.',
                'indicators' => [
                    'Acceleration' => 20.00,
                    'Agility' => 20.00,
                    'Crossing' => 20.00,
                    'Dribble' => 20.00,
                    'Speed Sprint' => 20.00,
                ],
            ],
            'WR/WL' => [
                'name' => 'Winger Left/Right',
                'description' => 'Pemain sayap lincah penembus pertahanan luar lawan.',
                'indicators' => [
                    'Acceleration' => 20.00,
                    'Crossing' => 20.00,
                    'Long Shoot' => 20.00,
                    'Dribble' => 20.00,
                    'Positioning' => 20.00,
                ],
            ],
            'ST' => [
                'name' => 'Striker',
                'description' => 'Ujung tombak pencetak gol utama di lini penyerangan.',
                'indicators' => [
                    'Acceleration' => 20.00,
                    'Composure' => 20.00,
                    'Heading' => 20.00,
                    'Long Shoot' => 20.00,
                    'Positioning' => 20.00,
                ],
            ],
        ];

        foreach ($positionsData as $code => $info) {
            $position = Position::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $info['name'],
                    'description' => $info['description'],
                ]
            );

            // Link Position ↔ Indicator
            foreach ($info['indicators'] as $indName => $weight) {
                $indicator = $indicators[$indName];
                PositionIndicator::updateOrCreate(
                    [
                        'position_id' => $position->id,
                        'indicator_id' => $indicator->id,
                    ],
                    [
                        'weight' => $weight,
                    ]
                );
            }
        }

        // 4. Map Indicators ↔ Tests
        $mappings = [
            'Composure' => ['Small-Sided Games Composure', 'Small-Sided Games'],
            'Long Pass' => ['Loughborough Soccer Passing Test (LSPT)'],
            'Jumping' => ['Vertical Jump'],
            'Strength' => ['Squat Jump', 'Vertical Jump'],
            'Reaction' => ['Wall Ball Test'],
            'Heading' => ['Target-Based Heading Test'],
            'Interceptions' => ['Small-Sided Game Interception'],
            'Marking' => ['Small-Sided Game Marking'],
            'Acceleration' => ['Test Sprint Acceleration'],
            'Speed Sprint' => ['40-m sprint test'],
            'Stamina' => ['Bleep Test'],
            'Ball Control' => ['Juggling Test'],
            'Long Shoot' => ['Shooting Test'],
            'Short Pass' => ['Short Pass Test'],
            'Agility' => ['T-Test'],
            'Crossing' => ['Crossing Test'],
            'Dribble' => ['Dribbling Test'],
            'Positioning' => ['Small-Sided Game Positioning'],
        ];

        foreach ($mappings as $indName => $testNames) {
            $indicator = $indicators[$indName];
            foreach ($testNames as $tName) {
                $test = $tests[$tName];
                IndicatorTest::updateOrCreate([
                    'indicator_id' => $indicator->id,
                    'test_id' => $test->id,
                ]);
            }
        }
    }
}
