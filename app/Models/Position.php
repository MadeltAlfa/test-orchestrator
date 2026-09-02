<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Position extends Model
{
      use HasFactory, HasUuids;

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi indikator posisi
     * many to many
     */
    public function indicators()
    {
        return $this->belongsToMany(
            Indicator::class,
            'position_indicator',
            'position_id',
            'indicator_id'
        )
        ->using(PositionIndicator::class)
        ->withPivot('weight')
        ->withTimestamps();
    }

    /**
     * Hasil assessment posisi
     */
    public function assessmentResults()
    {
        return $this->hasMany(AssessmentResult::class);
    }

    /**
     * Assessment posisi utama
     */
    public function finalAssessments()
    {
        return $this->hasMany(
            Assessment::class,
            'final_position_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Nama lengkap posisi
     * contoh:
     * GK - Goalkeeper
     */
    public function getFullNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }

    /**
     * Jumlah indikator posisi
     */
    public function getTotalIndicatorsAttribute()
    {
        return $this->indicators()->count();
    }

    /**
     * Jumlah pemain yang direkomendasikan
     */
    public function getTotalRecommendedPlayersAttribute()
    {
        return $this->finalAssessments()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Ambil total bobot posisi
     */
    public function getTotalWeight()
    {
        return $this->indicators()
            ->sum('weight');
    }

    /**
     * Ambil rata-rata score posisi
     */
    public function getAverageScore()
    {
        return round(
            $this->assessmentResults()->avg('score'),
            2
        );
    }

    /**
     * Cek apakah indicator digunakan posisi
     */
    public function hasIndicator($indicatorId)
    {
        return $this->indicators()
            ->where('indicators.id', $indicatorId)
            ->exists();
    }
}
