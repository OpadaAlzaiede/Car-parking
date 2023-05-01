<?php

namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class StartParkingRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id,deleted_at,NULL,user_id,'.auth()->id()],
            'zone_id' => ['required', 'integer', 'exists:zones,id']
        ];
    }
}
