<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\Repair;
use Illuminate\Database\Eloquent\Collection;

class RepairDto
{
    public int $id;
    public int $repairTypeId;
    public ?string $repairTypeName;

    public float $cost;
    public string $date;

    public function __construct(int $id, int $repairTypeId, ?string $repairTypeName, float $price, string $date)
    {
        $this->id = $id;
        $this->repairTypeId = $repairTypeId;
        $this->repairTypeName = $repairTypeName;
        $this->price = $price;
        $this->date = $date;
    }

    public static function fromEntity(Repair $repair): self
    {
        return new self(
            $repair->id,
            $repair->repairTypeId,
            $repair->repairTypeName,
            $repair->price,
            $repair->date
        );
    }


    public static function fromModel(\App\Models\Repair $repairModel): Repair
    {
        return new Repair(
            (int)$repairModel->id,
            (int)$repairModel->car_id,
            (int)$repairModel->repair_type_id,
            $repairModel->getRepairTypeNAme() ? (string)$repairModel->getRepairTypeNAme() : null, // Exemple de conversion
            (float)$repairModel->price,
            (string)$repairModel->date,
            $repairModel->is_planned_repair
        );
    }

    public static function fromCollection(Collection|array $repairs): array
    {
        return array_map(function (\App\Models\Repair $repairModel) {
            $repairEntity = self::fromModel($repairModel);
            return self::fromEntity($repairEntity);
        }, $repairs instanceof Collection ? $repairs->all() : $repairs);
    }

    public static function formatAllTypesForStats(array $repairsDto): array
    {
        $groupedData = collect($repairsDto)
            ->groupBy('repairTypeName')
            ->map(function ($group) {
                $totalCost = $group->sum('price');

                $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

                return [
                    'total' => $totalCost,
                    'color' => $randomColor,
                ];
            });

        $labels = $groupedData->keys()->toArray();
        $data = $groupedData->pluck('total')->toArray();
        $colors = $groupedData->pluck('color')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => '€',
                    'backgroundColor' => $colors,
                    'data' => $data,
                ]
            ]
        ];
    }

    public static function formatAllMonthsForStats(array $repairsDto): array
    {

        $groupedData = collect($repairsDto)
            ->groupBy(function ($repair) {
                return date('Y-m', strtotime($repair->date));
            })
            ->map(function ($group, $month) {
                $totalCost = $group->sum('price');

                return [
                    'total' => $totalCost,
                ];
            });

        $months = $groupedData->keys()->sort()->map(function ($month) {
            return date('F', strtotime($month . '-01'));
        })->toArray();

        $data = $groupedData->pluck('total')->toArray();

        $backgroundColor = '#f87979';

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Fluctuation des dépenses',
                    'backgroundColor' => $backgroundColor,
                    'data' => $data,
                ]
            ]
        ];
    }
}
