<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TestNorm extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'test_id',
        'category',
        'min_value',
        'max_value',
        'score',
        'operator',
    ];

    protected $casts = [
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'score' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Tes terkait
     */
    public function test()
    {
        return $this->belongsTo(
            SkillTest::class,
            'test_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Label range norma
     */
    public function getRangeLabelAttribute()
    {
        return match ($this->operator) {

            'between' =>
                $this->min_value . ' - ' . $this->max_value,

            'less_than' =>
                '< ' . $this->max_value,

            'greater_than' =>
                '> ' . $this->min_value,

            'less_equal' =>
                '≤ ' . $this->max_value,

            'greater_equal' =>
                '≥ ' . $this->min_value,

            default => '-',
        };
    }

    /**
     * Badge color kategori
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

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah value cocok dengan norma
     */
    public function matches($value)
    {
        return match ($this->operator) {

            'between' =>
                $value >= $this->min_value &&
                $value <= $this->max_value,

            'less_than' =>
                $value < $this->max_value,

            'greater_than' =>
                $value > $this->min_value,

            'less_equal' =>
                $value <= $this->max_value,

            'greater_equal' =>
                $value >= $this->min_value,

            default => false,
        };
    }

    /**
     * Format lengkap norma
     */
    public function getFullLabelAttribute()
    {
        $unit = $this->test?->unit;

        return "{$this->category} ({$this->range_label}) - Score {$this->score} {$unit}";
    }
}
