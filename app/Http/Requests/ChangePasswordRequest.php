<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Hash;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (! Hash::check($value, auth()->user()->password)) {
                        return $fail('Your current password is incorrect');
                    }
                }
            ],
            'new_password' => 'required|string|min:6|confirmed|different:current_password',
        ];
    }
}
