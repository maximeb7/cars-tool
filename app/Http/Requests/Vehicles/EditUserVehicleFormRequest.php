<?php

namespace App\Http\Requests\Vehicles;


use Illuminate\Foundation\Http\FormRequest;

class EditUserVehicleFormRequest extends FormRequest
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
            'id' => ["required", "integer", "exists:cars,id"],
            'brand_id' => ["required", "integer", "exists:brands,id"],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'model' => ['required', 'string'],
            'year' => ['required', 'string'],
            'plate' => ['required', 'string'],
            'kilometers' => ['required', 'string'],
            'image_path' => [
                'nullable',
                'sometimes',
                'file',
                'image',
                'mimes:jpeg,png,jpg',
                'max:5000',
            ],      ];
    }


}
