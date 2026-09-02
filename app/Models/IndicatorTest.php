<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class IndicatorTest extends Pivot
{
     use HasFactory, HasUuids;

    /**
     * Table pivot custom
     */
    protected $table = 'indicator_test';

    /**
     * Primary key UUID
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'indicator_id',
        'test_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Indicator terkait
     */
    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
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
     * Nama indicator
     */
    public function getIndicatorNameAttribute()
    {
        return $this->indicator?->name;
    }

    /**
     * Nama tes
     */
    public function getTestNameAttribute()
    {
        return $this->test?->name;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah relasi valid
     */
    public function isValid()
    {
        return $this->indicator && $this->test;
    }
}
