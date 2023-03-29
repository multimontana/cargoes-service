<?php

namespace App\Traits\Request;

use Illuminate\Http\Request;

trait RequestDataHelper
{
    /**
     * @param Request $request
     * @return array
     */
    public function setRequest(Request $request): array
    {
        $user = $request->user();

        return [
            'auth_user_id' => $user->id,
            'user' => $user,
            'query' => $request->query(),
            'body' => $request->all(),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function setRequestBody(Request $request): array
    {
        return [
            'body' => $request->all(),
        ];
    }
}
