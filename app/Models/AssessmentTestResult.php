<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssessmentTestResult extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'assessment_id',
        'test_id',
        'raw_value',
        'score',
        'category',
    ];

    protected $casts = [
        'raw_value' => 'decimal:2',
        'score' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Assessment induk
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Tes terkait
     */
    public function test()
    {
        return $this->belongsTo(SkillTest::class, 'test_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Format raw value + unit
     * contoh:
     * 3.45 detik
     * 95 sentuhan
     */
    public function getFormattedRawValueAttribute()
    {
        $unit = $this->test?->unit;

        if (!$unit) {
            return $this->raw_value;
        }

        return number_format($this->raw_value, 2) . ' ' . $unit;
    }

    /**
     * Badge color berdasarkan kategori
     */
    public function getBadgeColorAttribute()
    {
        return match ($this->category) {
            'Sangat Baik' => 'success',
            'Baik' => 'primary',
            'Sedang' => 'warning',
            'Cukup' => 'warning',
            'Kurang' => 'danger',
            default => 'dark',
        };
    }

    /**
     * Persentase score
     */
    public function getPercentageAttribute()
    {
        return ($this->score / 10) * 100;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Apakah hasil sangat baik
     */
    public function isExcellent()
    {
        return $this->score >= 9;
    }

    /**
     * Apakah hasil rendah
     */
    public function isLow()
    {
        return $this->score <= 4;
    }
}
