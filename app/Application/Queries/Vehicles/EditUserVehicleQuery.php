<?php

namespace App\Application\Queries\Vehicles;

namespace App\Application\Queries\Vehicles;

use Illuminate\Http\UploadedFile;

class EditUserVehicleQuery
{
    public int $brandId;
    public int $userId;
    public string $model;
    public string $year;
    public string $plate;
    public ?string $imagePath; // Peut être une chaîne ou null
    public ?string $kilometers;

    public function __construct(
        int $id,
        int $brandId,
        int $userId,
        string $model,
        string $year,
        string $plate,
        $imagePath = null, // Définit une valeur par défaut à null
        ?string $kilometers = null // Valeur par défaut à null
    )
    {
        $this->id = $id;
        $this->brandId = $brandId;
        $this->userId = $userId;
        $this->model = $model;
        $this->year = $year;
        $this->plate = $plate;

        // Assigne imagePath
        if ($imagePath instanceof UploadedFile) {
            $this->imagePath = $imagePath->store('vehicles', 'public'); // stocke le fichier et assigne le chemin
        } elseif (is_string($imagePath)) {
            $this->imagePath = $imagePath; // si c'est déjà une chaîne
        } else {
            $this->imagePath = null; // sinon, assigne null
        }

        $this->kilometers = $kilometers;
    }
}
