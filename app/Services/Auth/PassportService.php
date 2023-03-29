<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client as OClient;

class PassportService
{
    /**
     * @var OClient
     */
    private OClient $client;

    /**
     * PassportService constructor.
     */
    public function __construct()
    {
        $this->client = OClient::where('password_client', '=', 1)->first();
    }

    /**
     * @param $user
     * @param string $password
     * @return array|null
     */
    public function getAccessAndRefreshTokens($user, string $password): ?array
    {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $user->email,
            'password' => $password,
            'scope' => '*',
        ]);

        $response = $response->json();

        if (!$user->username) {
            $response['is_registered'] = false;
        } else {
            $response['is_registered'] = true;
        }

        return $response;
    }

    /**
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array
    {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => '*',
        ]);

        return $response->json();
    }
}
