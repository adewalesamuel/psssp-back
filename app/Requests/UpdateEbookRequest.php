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
            'name' => 'nullable|string',
			'slug' => 'nullable|string|unique:ebooks',
			'type' => 'nullable|string',
			'download_code' => 'nullable|string',
			'description' => 'nullable|string',
			'price' => 'nullable|integer',
			'initial_stock' => 'nullable|integer',
			'img_url' => 'nullable|string',
			'file_url' => 'nullable|string',

        ];
    }
}
