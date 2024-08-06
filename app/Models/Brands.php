<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brands';

    protected $fillable = [
        'name'
    ];


    public function cars(): HasMany
    {
        return $this->hasMany(Cars::class);
    }
}
