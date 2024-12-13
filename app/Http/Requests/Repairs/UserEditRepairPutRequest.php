<?php

namespace App\Http\Requests\Repairs;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRepairPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array>
     */
    public function rules()
    {
        return [
            'id' => ["required", "integer", "exists:repairs,id"],
            'car_id' => ["required", "integer", "exists:cars,id"],
            'date' => ['required', 'date'],
            'is_planned_repair' => ['required', 'bool'],
            'price' => ['required', 'numeric'],
            'repair_type_id' => ['required', 'exists:repair_types,id']
            ];
    }


}
