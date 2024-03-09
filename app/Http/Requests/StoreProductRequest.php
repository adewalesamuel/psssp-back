<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string',
			'slug' => 'nullable|string|unique:products',
			'description' => 'nullable|string',
			'price' => 'required|integer',
			'download_code' => 'nullable|string',
			'initial_stock' => 'required|integer',
			'current_stock' => 'required|integer',
			'img_url' => 'nullable|string',
			'file_url' => 'required|string',
            'is_public' => 'nullable|boolean',
			'account_id' => 'nullable|integer|exists:accounts,id',
			'category_id' => 'required|integer|exists:categories,id',

        ];
    }
}
