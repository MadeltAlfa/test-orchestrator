<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PositionIndicator extends Pivot
{
     use HasFactory, HasUuids;

    /**
     * Table pivot custom
     */
    protected $table = 'position_indicator';

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'position_id',
        'indicator_id',
        'weight',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Posisi terkait
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
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
     * Nama posisi
     */
    public function getPositionNameAttribute()
    {
        return $this->position?->name;
    }

    /**
     * Nama indicator
     */
    public function getIndicatorNameAttribute()
    {
        return $this->indicator?->name;
    }

    /**
     * Persentase bobot
     * contoh:
     * 25%
     */
    public function getWeightPercentageAttribute()
    {
        return number_format($this->weight, 2) . '%';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah bobot tinggi
     */
    public function isImportant()
    {
        return $this->weight >= 20;
    }
}
