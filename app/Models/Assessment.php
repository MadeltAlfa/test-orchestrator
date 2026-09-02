<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Assessment extends Model
{
     use HasFactory, HasUuids;

    /**
     * Primary key bukan increment
     */
    public $incrementing = false;

    /**
     * Type primary key string
     */
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'player_id',
        'assessment_date',
        'final_position_id',
        'total_score',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'total_score' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($assessment) {

            if (empty($assessment->id)) {
                $assessment->id = (string) Str::uuid();
            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * User/Pelatih pemilik assessment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pemain yang di-assess
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Posisi akhir rekomendasi
     */
    public function finalPosition()
    {
        return $this->belongsTo(Position::class, 'final_position_id');
    }

    /**
     * Hasil tes mentah
     */
    public function testResults()
    {
        return $this->hasMany(AssessmentTestResult::class);
    }

    /**
     * Skor indikator
     */
    public function scores()
    {
        return $this->hasMany(AssessmentScore::class);
    }

    /**
     * Ranking posisi
     */
    public function results()
    {
        return $this->hasMany(AssessmentResult::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Posisi terbaik
     */
    public function getBestPositionAttribute()
    {
        return $this->results()
            ->orderByDesc('score')
            ->first();
    }

    /**
     * Semua ranking posisi
     */
    public function getPositionRankingsAttribute()
    {
        return $this->results()
            ->with('position')
            ->orderByDesc('score')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Hitung total skor indikator
     */
    public function calculateTotalScore()
    {
        return $this->scores()->sum('score');
    }

    /**
     * Update total skor
     */
    public function updateTotalScore()
    {
        $this->update([
            'total_score' => $this->calculateTotalScore()
        ]);
    }
}
