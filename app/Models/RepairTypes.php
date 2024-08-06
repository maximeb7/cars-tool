<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairTypes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'repair_types';

    protected $fillable = [
        'name'
    ];

    public function repairs(): HasMany
    {
        return $this->hasMany(Repairs::class);
    }
}
