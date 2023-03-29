<?php

namespace App\Repositories\Auth;

use App\Entity\UserPackages\User;
use App\Exceptions\Auth\AuthenticateException;
use App\Repositories\AbstractRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class AuthRepository extends AbstractRepository
{
    /**
     * AuthRepository constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * @return Builder|Model|object|null
     *
     * @throws AuthenticateException
     */
    public function checkCredentials()
    {
        $credentials = request(['email', 'email_code']);

        $user = $this->model
            ->newQuery()
            ->where('email', '=', strtolower($credentials['email']))
            ->first();

        if ($user->email_code !== $credentials['email_code']) {
            throw new
            AuthenticateException(Lang::get('auth.failed'), JsonResponse::HTTP_UNAUTHORIZED, ['type' => 'auth']);
        }

        $data = $user;
//        $user->update(['email_code' => null]);

        return $data;
    }


    /**
     * @return Builder|Model|object|null
     *
     * @throws AuthenticateException
     */
    public function checkPasswordCredentials()
    {
        $credentials = request(['email', 'login_password']);

        $user = $this->model
            ->newQuery()
            ->where('email', '=', strtolower($credentials['email']))
            ->first();

        if ($user) {
            if (!Hash::check($credentials['login_password'], $user->login_password)) {
                throw new
                AuthenticateException(Lang::get('auth.failed'), JsonResponse::HTTP_UNAUTHORIZED, ['type' => 'auth']);
            }
        } else {
            throw new
            AuthenticateException(Lang::get('auth.failed'), JsonResponse::HTTP_UNAUTHORIZED, ['type' => 'auth']);
        }

        return $user;
    }

    /**
     * @param object $user
     * @param array $data
     *
     * @return object
     */
    public function createToken(object $user, array $data): object
    {
        $personalToken = $user->createToken($data['email'] . " - " . now());
        $token = $personalToken->token;

        if (isset($data['remember_me'])) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return $personalToken;
    }
}
