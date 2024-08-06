<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repairs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'repairs';
    protected $fillable = [
        'car_id',
        'repair_type_id',
        'price',
        'date',
        'is_planned_repair',
    ];

    protected function casts(): array
    {
        return [
            'car_id' => 'int',
            'repair_type_id' => 'int',
            'price' => 'float',
            'date' => 'date',
            'is_planned_repair' => 'bool',
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Cars::class);
    }


    public function repairType(): BelongsTo
    {
        return $this->belongsTo(RepairTypes::class);
    }


}
