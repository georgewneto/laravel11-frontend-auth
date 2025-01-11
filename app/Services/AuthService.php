<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class AuthService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:8081']);
    }

    public function login($credentials)
    {
        $response = $this->client->post('/api/login', [
            'json' => $credentials,
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['token'])) {
            Session::put('token', $data['token']);
        }

        return $data;
    }

    public function register($data)
    {
        $response = $this->client->post('/api/register', [
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function logout()
    {
        Session::forget('token');
    }

    public function forgotPassword($data)
    {
        $response = $this->client->post('/api/forgotpassword', [
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function me()
    {
        $response = $this->client->get('/api/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
