<?php

namespace App\Services\User;

use App\Exceptions\Auth\AuthenticateException;
use App\Repositories\User\UserRepository;
use App\Services\Auth\PassportService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class UserService
{
    /**
     * @vars UserRepository, PassportService, AuthService
     */
    private UserRepository $userRepository;
    private PassportService $passportService;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     * @param PassportService $passportService
     */
    public function __construct(
        UserRepository $userRepository,
        PassportService $passportService
    ) {
        $this->userRepository = $userRepository;
        $this->passportService = $passportService;
    }

    public function update(array $request)
    {
        return $this->userRepository
            ->update($request['body'], $request['auth_user_id']);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->userRepository
            ->delete($id);
    }

    /**
     * @param array $data
     *
     * @param Model $user
     * @return bool|null
     * @throws AuthenticateException
     */
    public function updatePassword(array $data, Model $user): ?bool
    {
        if (isset($data['old_password']) && !password_verify($data['old_password'], $user->password)) {
            throw new
            AuthenticateException(Lang::get('auth.failed'), JsonResponse::HTTP_UNAUTHORIZED, ['type' => 'auth']);
        }

        $data['login_password'] = bcrypt($data['new_password']);

        return $this->userRepository
            ->update($data, $user->id);
    }

    /**
     * @param string $refreshToken
     *
     * @return array
     */
    public function refreshToken(string $refreshToken): array
    {
        return $this->passportService->refreshToken($refreshToken);
    }

    /**
     * @return Authenticatable
     */
    public function getUser(): Authenticatable
    {
        return $this->userRepository
            ->getUser();
    }
}
