<?php

namespace App\Http\Requests\Regions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class RegionsUpdateValidation extends FormRequest
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
           'slug' => ['required','string','max:100',Rule::unique('regions')->ignore($this->region->id)],//исключаем текущий slug из проверки на уникальность
            'parent_id' => [
                'nullable',
                 Rule::notIn([$this->region->id]),  //запрещаем сделать родителем самого себя
                'exists:regions,id',                //проверяем чтобы введенный parent_id был реальным id в таблице regions
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
