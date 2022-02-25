<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'image' => 'sometimes|nullable|image|mimes:jpg,png,jpeg,gif,svg|Max:4056',
            'imagable_type' => 'required',
            'imagable_id' => 'required',
            'alt' => 'required',
        ];
    }
}
