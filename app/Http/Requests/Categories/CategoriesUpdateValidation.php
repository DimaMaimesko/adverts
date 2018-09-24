<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CategoriesUpdateValidation extends FormRequest
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
           'name' => 'required|string|max:200',
           'slug' => ['required','string','max:100',Rule::unique('advert_categories')->ignore($this->category->id)],//исключаем текущий slug из проверки на уникальность
            'parent_id' => [
                'nullable',
                 Rule::notIn([$this->category->id]),  //запрещаем сделать родителем самого себя
                'exists:advert_categories,id',        //проверяем чтобы введенный parent_id был реальным id в таблице regions
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
