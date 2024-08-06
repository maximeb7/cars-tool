<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cars extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cars';

    protected $fillable = [
        'brand_id',
        'model',
        'year',
    ];

    protected function casts(): array
    {
        return [
            'brand_id' => 'int',
        ];
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function brand(): BelongsTo
    {
        return $this->belongsTo(Brands::class);
    }

    protected function repairs(): HasMany
    {
        return $this->hasMany(Repairs::class);
    }
}
