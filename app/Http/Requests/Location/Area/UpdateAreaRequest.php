<?php

namespace App\Http\Requests\Location\Area;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:areas|min:3',
            'description' => 'required',
            'icon' => 'nullable|mimes:jpeg,jpg,png|max:500',
        ];
    }
}
