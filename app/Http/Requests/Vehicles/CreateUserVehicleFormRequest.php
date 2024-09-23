<?php

namespace App\Http\Requests\Vehicles;


use Illuminate\Foundation\Http\FormRequest;

class CreateUserVehicleFormRequest extends FormRequest
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
            'brand_id' => ["required","integer","exists:brands,id"],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'model' => ['required', 'string'],
            'year' => ['required', 'string'],
            'plate' => ['required', 'string'],
            'image_path' => ['nullable','image', 'file', 'mimes:jpeg,png,jpg', 'max:5000'],
        ];
    }
}
