<?php

namespace App\Requests\Auth;

use App\Requests\AbstractFormRequest;

class SendEmailForResetPasswordRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|string|max:255'
        ];
    }
}
