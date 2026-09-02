<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SkillTest extends Model
{
      use HasFactory, HasUuids;

    /**
     * Table name
     */
    protected $table = 'tests';

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'input_type',
        'unit',
        'use_stopwatch',
        'use_increment',
    ];

    protected $casts = [
        'use_stopwatch' => 'boolean',
        'use_increment' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi indicator
     * many to many
     */
    public function indicators()
    {
        return $this->belongsToMany(
            Indicator::class,
            'indicator_test',
            'test_id',
            'indicator_id'
        )
        ->using(IndicatorTest::class)
        ->withPivot('id')
        ->withTimestamps();
    }

    /**
     * Guide / panduan tes
     */
    public function guide()
    {
        return $this->hasOne(TestGuide::class, 'test_id');
    }

    /**
     * Norma penilaian tes
     */
    public function norms()
    {
        return $this->hasMany(TestNorm::class, 'test_id');
    }

    /**
     * Hasil tes user
     */
    public function assessmentTestResults()
    {
        return $this->hasMany(
            AssessmentTestResult::class,
            'test_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Tipe input label
     */
    public function getInputTypeLabelAttribute()
    {
        return match ($this->input_type) {
            'time' => 'Waktu',
            'number' => 'Angka',
            default => '-',
        };
    }

    /**
     * Mode input
     */
    public function getInputModeAttribute()
    {
        if ($this->use_stopwatch) {
            return 'stopwatch';
        }

        if ($this->use_increment) {
            return 'increment';
        }

        return 'manual';
    }

    /**
     * Jumlah indikator terkait
     */
    public function getTotalIndicatorsAttribute()
    {
        return $this->indicators()->count();
    }

    /**
     * Jumlah norma tes
     */
    public function getTotalNormsAttribute()
    {
        return $this->norms()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah test memakai stopwatch
     */
    public function usesStopwatch()
    {
        return $this->use_stopwatch;
    }

    /**
     * Cek apakah test memakai increment
     */
    public function usesIncrement()
    {
        return $this->use_increment;
    }

    /**
     * Cari norma berdasarkan nilai input
     */
    public function findNorm($value)
    {
        return $this->norms
            ->first(function ($norm) use ($value) {

                return match ($norm->operator) {

                    'between' =>
                        $value >= $norm->min_value &&
                        $value <= $norm->max_value,

                    'less_than' =>
                        $value < $norm->max_value,

                    'greater_than' =>
                        $value > $norm->min_value,

                    'less_equal' =>
                        $value <= $norm->max_value,

                    'greater_equal' =>
                        $value >= $norm->min_value,

                    default => false,
                };
            });
    }
}
