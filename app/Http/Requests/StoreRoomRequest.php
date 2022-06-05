<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::user()) return  false;
        return Auth::user()->can('create',Room::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>"required|min:3",
            'description'=>"required|min:10",
            'image'=>"sometimes|nullable|image",
            'code'=>[Rule::requiredIf($this['visibility'] == Room::$PrivateRoom), Rule::unique('rooms','code')],
            'visibility'=>['required',Rule::in(array_keys(Room::$Visibilities))],
            'level_id'=>['required',Rule::exists('levels','id')],
        ];
    }
}
