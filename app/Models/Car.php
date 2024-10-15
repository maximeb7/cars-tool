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
        'plate',
        'image_path',
        'kilometers'
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

    public function getFullName(): ?string
    {
        return $this->getBrandName(). ' '. $this->model;
    }

    protected function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function getRepairs(): Collection
    {
        return $this->repairs;
    }

    public function setImageAttribute($value)
    {
        if ($value) {
            $path = $value->store('cars', 'public');
            $this->attributes['image_path'] = $path;
        }
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : null;
    }
}
