<?php

namespace App\Services\Auth;

use App\Entity\UserPackages\User;
use App\Exceptions\Auth\AuthenticateException;
use App\Exceptions\Common\HttpNotFoundException;
use App\Exceptions\Common\PermissionDeniedException;
use App\Jobs\AuthVerifyJob;
use App\Jobs\ResetPasswordJob;
use App\Repositories\User\PasswordResetRepository;
use App\Resources\Auth\AuthResource;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\User\UserRepository;
use App\Services\AbstractService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use stdClass;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthService extends AbstractService
{
    /**
     * @var AuthRepository,
     * @var UserRepository,
     * @var PasswordResetRepository
     */
    private AuthRepository $authRepository;
    private UserRepository $userRepository;
    private PasswordResetRepository $passwordResetRepository;

    /**
     * AuthService constructor.
     *
     * @param AuthRepository $authRepository
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(
        AuthRepository $authRepository,
        UserRepository $userRepository,
        PasswordResetRepository $passwordResetRepository
    ) {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * @param array $data
     *
     * @return AuthResource|array
     * @throws AuthenticateException
     */
    public function authorization(array $data)
    {
        if (isset($data['email']) && isset($data['email_code'])) {
            $data['email'] = strtolower($data['email']);
            $currentPassword = $data['email_code'] . $data['email'];
            return $this->getToken($currentPassword);
        }

        if (isset($data['email'])) {
            return $this->sendEmail($data);
        }
    }

    /**
     * @param array $data
     *
     * @return AuthResource
     */
    public function sendEmail(array $data)
    {
        //todo rand(10, 1000) временное решение
        $verificationCode = rand(10, 1000);
        $data['email_code'] = $verificationCode;
        $data['email_password'] = bcrypt($verificationCode . $data['email']);
        $user = $this->userRepository
            ->updateOrCreate(['email' => $data['email']], $data);

        if ($user) {
            AuthVerifyJob::dispatch($data['email'], $verificationCode);
        }

        return new AuthResource($user);
    }

    /**
     * @param string $password
     *
     * @return array|null
     * @throws AuthenticateException
     */
    public function getToken(string $password): ?array
    {
        $user = $this->authRepository->checkCredentials();
        $user->password = $user->getEmailPassword();
        $user->save();

        $personalToken = $this->createToken($user, $user->email);
        $registered = null;

        if (!$user->username) {
            $registered = false;
        } else {
            $registered = true;
        }

        return [
            "token_type" => "Bearer",
            "expires_in" => Carbon::parse(
                $personalToken->token->expires_at
            )->toDateTimeString(),
            "access_token" => $personalToken->accessToken,
            "refresh_token" => $personalToken->accessToken,
            "is_registered" => $registered
        ];
    }


    /**
     * @param string $password
     *
     * @return array|null
     * @throws AuthenticateException
     */
    public function getPasswordToken(string $password): ?array
    {
        $user = $this->authRepository->checkPasswordCredentials();
        $user->password = $user->getLoginPassword();
        $user->save();
        $personalToken = $this->createToken($user, $user->email);
        $registered = null;

        if (!$user->username) {
            $registered = false;
        } else {
            $registered = true;
        }

        return [
            "token_type" => "Bearer",
            "expires_in" => Carbon::parse(
                $personalToken->token->expires_at
            )->toDateTimeString(),
            "access_token" => $personalToken->accessToken,
            "refresh_token" => $personalToken->accessToken,
            "is_registered" => $registered
        ];
    }

    /**
     * @param array $data
     *
     * @return array|null
     * @throws AuthenticateException
     */
    public function signInWithPassword(array $data): ?array
    {
        return $this->getPasswordToken($data['login_password']);
    }

    /**
     * @param array $data
     *
     * @return object|null
     */
    public function sendEmailForResetPassword(array $data): ?object
    {
        $user = $this->userRepository
            ->findOneByEmail($data['email']);

        if (is_null($user)) {
            throw new HttpNotFoundException('email does not exist');
        }

        $url = URL::temporarySignedRoute(
            'refresh-password',
            now()->addDays(1),
            [
                'email' => $data['email']
            ]
        );

        parse_str(parse_url($url, PHP_URL_QUERY), $output);
        $data['token'] = $output['signature'];

        $signature = $this->passwordResetRepository
            ->newQuery()
            ->where('email', '=', $data['email']);

        if (is_null($signature->first())) {
            $signature->create($data);
        } else {
            $signature->update(['token' => $data['token']]);
        }

        if (!config('app.local-mode')) {
            $url = explode('/', $url);
            $url[0] = 'https://';
            if (!config('app.dev-mode')) {
                $url[2] = config('app.production');
            } else {
                $url[2] = config('app.development');
            }
            $url = implode($url);
        }

        ResetPasswordJob::dispatch($data['email'], $url);

        return new stdClass();
    }

    /**
     * @param array $queryOptions
     *
     * @return array
     */
    public function getResetPasswordData(array $queryOptions): array
    {
        return $queryOptions;
    }

    /**
     * @param object $user
     * @param string $email
     * @return object
     */
    public function createToken(object $user, string $email): object
    {
        $personalToken = $user->createToken(strtolower($email) . " - " . now());
        $token = $personalToken->token;

        if (isset($data['remember_me'])) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return $personalToken;
    }
    /**
     * @param array $data
     *
     * @return object|null
     */
    public function resetPassword(array $data): ?object
    {
        $user = $this->userRepository
            ->findOneByEmail($data['email']);

        $passwordReset = $this->passwordResetRepository
            ->findOneByEmail($data['email']);

        if (is_null($passwordReset)) {
            throw new PermissionDeniedException('permission denied');
        }

        if ($data['signature'] !== $passwordReset->token) {
            throw new PermissionDeniedException('permission denied');
        }

        if (is_null($user)) {
            throw new HttpNotFoundException('email does not exist');
        }

        $user->update([
            'password' => bcrypt($data['new_password']),
            'email_password' => bcrypt($data['new_password']),
            'login_password' => bcrypt($data['new_password']),
        ]);
        $passwordReset
            ->newQuery()
            ->where('email', '=', $data['email'])
            ->delete();

        return new stdClass();
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        Auth::user()->token()->revoke();
        return true;
    }

    public function toGoogleAuth(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function getUserByGoogleAuth(): User
    {
        $user = Socialite::driver('google')->user();

        return $this->userRepository->findOrCreateUserByGoogleAuth($user);
    }

    public function createPassportTokenByGoogleId(User $user): array
    {
        $token = $this->createToken($user, $user->email);

        return [
            "token_type" => "Bearer",
            "expires_in" => Carbon::parse(
                $token->token->expires_at
            )->toDateTimeString(),
            "access_token" => $token->accessToken,
            "refresh_token" => $token->accessToken,
            "is_registered" => true,
        ];
    }
}
