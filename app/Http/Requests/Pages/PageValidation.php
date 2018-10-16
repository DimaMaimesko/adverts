<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageValidation extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'menu_title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:pages,id',   //проверяем чтобы введенный parent_id был реальным id в таблице categories
            ],
        ];
    }

    public function messages()
    {
        return [
            'parent_id.exists' => 'You should enter a parent_id which is exist!  ',
        ];
    }
}
