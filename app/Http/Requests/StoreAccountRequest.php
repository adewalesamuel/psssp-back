<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            'email' => 'required|string|unique:accounts',
            'password' => 'required|string',
            'backup_number' => 'required|string',
            'whatsapp_number' => 'required|string',
            'telegram_number' => 'required|string',
            'shop_name' => 'required|string',
            'profile_img_url' => 'nullable|string',
            'referer_sponsor_code' => 'nullable|string|exists:users,sponsor_code',
            'country_id' => 'required|integer|exists:countries,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'phone_number' => 'required|string',
        ];
    }
}
