<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssessmentScore extends Model
{
    use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'assessment_id',
        'indicator_id',
        'indicator_name',
        'score',
        'notes',
    ];

    protected $casts = [
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
     * Indicator terkait
     */
    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Label kategori berdasarkan skor
     */
    public function getCategoryLabelAttribute()
    {
        return match (true) {
            $this->score >= 9 => 'Sangat Baik',
            $this->score >= 7 => 'Baik',
            $this->score >= 5 => 'Sedang',
            $this->score >= 3 => 'Kurang',
            default => 'Sangat Kurang',
        };
    }

    /**
     * Badge color bootstrap
     */
    public function getBadgeColorAttribute()
    {
        return match (true) {
            $this->score >= 9 => 'success',
            $this->score >= 7 => 'primary',
            $this->score >= 5 => 'warning',
            $this->score >= 3 => 'danger',
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
     * Cek apakah score tinggi
     */
    public function isExcellent()
    {
        return $this->score >= 9;
    }

    /**
     * Cek apakah score rendah
     */
    public function isLow()
    {
        return $this->score <= 4;
    }
}
