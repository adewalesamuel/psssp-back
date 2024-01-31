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
            'fullname' => 'required|string',
			'email' => 'required|string|unique:admins',
			'password' => 'required|string|unique:admins',
			'profile_img_url' => 'required|string',
			'role_id' => 'required|integer|exists:roles,id',
			
        ];
    }
}