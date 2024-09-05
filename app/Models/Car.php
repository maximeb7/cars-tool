<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cars';

    protected $fillable = [
        'user_id',
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
        return $this->belongsTo(Brand::class);
    }

    public function getBrandName(): ?string
    {
        return $this->brand->name;
    }

    protected function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function getRepairs(): Collection
    {
        return $this->repairs;
    }
}
