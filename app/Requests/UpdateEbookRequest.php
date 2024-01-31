<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEbookRequest extends FormRequest
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
			'slug' => 'required|string|unique:ebooks',
			'type' => 'required|string',
			'download_code' => 'required|string',
			'description' => 'required|string',
			'price' => 'required|integer',
			'initial_stock' => 'required|integer',
			'img_url' => 'required|string',
			'file_url' => 'required|string',
			
        ];
    }
}