<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'nullable|string',
			'slug' => 'nullable|string',
			'description' => 'nullable|string',
			'price' => 'nullable|integer',
			'download_code' => 'nullable|string',
			'initial_stock' => 'nullable|integer',
			'current_stock' => 'nullable|integer',
			'img_url' => 'nullable|string',
			'file_url' => 'nullable|string',
			'user_id' => 'nullable|integer|exists:users,id',
			'category_id' => 'nullable|integer|exists:categories,id',

        ];
    }
}
