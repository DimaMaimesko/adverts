<?php

namespace App\Http\Requests\Users;

use App\Http\Controllers\Admin\UsersController;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersUpdateValidation extends FormRequest
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
           'name' => 'required|string|max:100|min:3',
           'email' => 'required|string|email|max:100|unique:users,id,'.$this->user->id,//исключаем текущий email из проверки на уникальность
//           'status' => ['required','string', Rule::in([User::STATUS_WAIT, User::STATUS_ACTIVE])],
        ];
    }
}
