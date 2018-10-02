<?php

namespace App\Http\Requests\Adverts;

use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Category $category
 * @property Region $region
 */
class RejectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return array_merge([
            'reason' => 'required|string',
            ]);
    }
}
