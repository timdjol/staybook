<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'title_en' => 'required|min:3|max:255',
            'description' => 'required|min:5',
            'description_en' => 'required|min:5',
            'hotel_id' => 'required|min:2',
            'area' => 'required|min:1',
            'count' => 'required|min:1',
            'price' => 'required|min:2',
            'pricec' => 'required|min:2',
            //'extra_place' => 'required|min:2',
            //'markup' => 'required|min:1',
            //'cancelled' => 'required|min:5',
            'include' => 'required|min:5',
            'bed' => 'required|min:5',
            'image' => 'image|mimes:jpg,bmp,png,svg,jpeg,webp|max:3000'
        ];
        return $rules;
    }

    public function messages()
    {
        return[
            'required'=>'Поле :attribute обязательно для ввода',
            'min' => 'Поле :attribute должно иметь минимум :min символов',
        ];
    }
}
