<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Indicator extends Model
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
        'scoring_note',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke posisi
     * many to many
     */
    public function positions()
    {
        return $this->belongsToMany(
            Position::class,
            'position_indicator'
        )
        ->using(PositionIndicator::class)
        ->withPivot('weight')
        ->withTimestamps();
    }

    /**
     * Relasi ke tes
     * many to many
     */
    public function tests()
    {
        return $this->belongsToMany(
            SkillTest::class,
            'indicator_test',
            'indicator_id',
            'test_id'
        )
        ->using(IndicatorTest::class)
        ->withPivot('id')
        ->withTimestamps();
    }

    /**
     * Assessment score
     */
    public function assessmentScores()
    {
        return $this->hasMany(AssessmentScore::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Nama lengkap indikator
     * contoh:
     * ACC - Acceleration
     */
    public function getFullNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }

    /**
     * Jumlah posisi yang memakai indikator
     */
    public function getTotalPositionsAttribute()
    {
        return $this->positions()->count();
    }

    /**
     * Jumlah tes terkait indikator
     */
    public function getTotalTestsAttribute()
    {
        return $this->tests()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Ambil rata-rata skor indicator
     */
    public function getAverageScore()
    {
        return round(
            $this->assessmentScores()->avg('score'),
            2
        );
    }

    /**
     * Cek apakah indicator digunakan posisi tertentu
     */
    public function usedInPosition($positionId)
    {
        return $this->positions()
            ->where('positions.id', $positionId)
            ->exists();
    }
}
