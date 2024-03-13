<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'fullname' => 'nullable|string',
			'email' => 'nullable|string',
			'password' => 'nullable|string',
			'profile_img_url' => 'nullable|string',
			'role_id' => 'nullable|integer|exists:roles,id',

        ];
    }
}
