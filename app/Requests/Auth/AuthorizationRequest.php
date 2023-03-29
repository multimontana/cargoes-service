<?php

namespace App\Requests\Auth;

use App\Requests\AbstractFormRequest;
use App\Rules\LowerRule;
use Illuminate\Support\Facades\DB;

class AuthorizationRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->email_code || !$this->is_register) {
            return [
                'email' => ['required', 'email', function ($attribute, $value, $fail) {
                    $user = DB::table('users')
                        ->where('email', strtolower($this->email))
                        ->first();
                    if(!$user) {
                        $fail('The selected email is invalid');
                    }
                }],
                'blocked' => 'string|boolean'
            ];
        } else {
            return [
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        $user = DB::table('users')
                            ->where('email', strtolower($this->email))
                            ->first();
                        if($user) {
                            $fail('The email '. $value .' already exists');
                        }
                    }
                ],
                'blocked' => 'string|boolean'
            ];
        }
    }

    /**
     * @param array $rules
     * @param mixed ...$params
     * @return array|bool
     */
    public function validate(array $rules, ...$params)
    {
        parent::validate($rules, $params);

        return in_array($rules, [
            '1', 1, "true", true, 'yes', 'on',
            '0', 0, "false", false, 'no', 'off', ''
        ], true);
    }
}
