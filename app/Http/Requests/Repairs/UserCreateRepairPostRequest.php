<?php

namespace App\Http\Requests\Repairs;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserCreateRepairPostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'car_id' => 'required|integer|exists:cars,id,user_id,' . Auth::id(),
            'date' => 'required|date',
            'is_planned_repair' => 'required|boolean',
            'price' => 'required|numeric',
            'repair_type_id' => 'required|integer|exists:repair_types,id',
        ];
    }

    public function messages()
    {
        return [
            'car_id.required' => 'Le champ car_id est requis.',
            'car_id.integer' => 'Le champ car_id doit être un entier.',
            'date.required' => 'Le champ date est requis.',
            'date.date' => 'Le champ date doit être une date valide.',
            'is_planned_repair.required' => 'Le champ is_planned_repair est requis.',
            'is_planned_repair.boolean' => 'Le champ is_planned_repair doit être vrai ou faux.',
            'price.required' => 'Le champ price est requis.',
            'price.numeric' => 'Le champ price doit être un nombre.',
            'repair_type_id.required' => 'Le champ repair_type_id est requis.',
            'repair_type_id.integer' => 'Le champ repair_type_id doit être un entier.',
        ];
    }
}
