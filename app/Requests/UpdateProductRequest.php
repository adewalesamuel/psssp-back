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
            'name' => 'required|string',
			'slug' => 'required|string|unique:products',
			'description' => 'required|string',
			'price' => 'required|integer',
			'download_code' => 'required|string',
			'initial_stock' => 'required|integer',
			'current_stock' => 'required|integer',
			'img_url' => 'required|string',
			'file_url' => 'required|string',
			'user_id' => 'required|integer|exists:users,id',
			'category_id' => 'required|integer|exists:categories,id',
			
        ];
    }
}