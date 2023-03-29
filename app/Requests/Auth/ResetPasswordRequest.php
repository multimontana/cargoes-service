<?php

namespace App\Requests\Auth;

use App\Requests\AbstractFormRequest;

class ResetPasswordRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|string|max:255',
            'new_password' => 'required'
        ];
    }
}
