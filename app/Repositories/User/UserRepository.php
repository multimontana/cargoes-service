<?php

namespace App\Repositories\User;

use App\Entity\UserPackages\User;
use App\Repositories\AbstractRepository;
use DomainException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class UserRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * @return Authenticatable
     */
    public function getUser(): Authenticatable
    {
        return Auth::user();
    }

    /**
     * @throw DomainException
     */
    public function findOrCreateUserByGoogleAuth(SocialiteUser $user): User
    {
        $userForAuth = $this->findByGoogleId($user->id);
        $rawData = (array)$user->user;

        if (is_null($userForAuth)) {
            /** @var User $userByGoogleEmail */
            $userByGoogleEmail = $this->findOneByEmail($user->email);

            if (!is_null($userByGoogleEmail)) {
                if (!is_null($userByGoogleEmail->google_id)) {
                    throw new DomainException('Пользователь с адресом ' . $user->email . ' уже существует.', 409);
                }

                $dataForUpdate = [
                    'google_id' => $user->id,
                    'username' => $userByGoogleEmail->username ?? $rawData['given_name'] ?? null,
                    'surname' => $userByGoogleEmail->surname ?? $rawData['family_name'] ?? null,
                ];

                $userByGoogleEmail->update($dataForUpdate);

                $userForAuth = $userByGoogleEmail;
            } else {
                $userForAuth = $this->create([
                    'username' => $rawData['given_name'] ?? null,
                    'surname' => $rawData['family_name'] ?? null,
                    'email' => $user->email,
                    'google_id' => $user->id,
                ]);
            }
        }

        return $userForAuth;
    }

    public function findByGoogleId(string $googleId): ?User
    {
        return User::where('google_id', $googleId)->first();
    }
}
