<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class AuthService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('SERVICE_AUTH')]);
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
        Session::forget('user');
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

    public function updateProfile($data)
    {
        $response = $this->client->post('/api/users/update', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getUsers()
    {
        $response = $this->client->get('/api/users', [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getUser(int $id)
    {
        $response = $this->client->get('/api/users/edit/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function updateUser($data)
    {
        $response = $this->client->post('/api/users/update', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getRoles()
    {
        $response = $this->client->get('/api/roles', [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function removeRoleFromUser($user_id, $role)
    {
        $data = [
            'user_id' => $user_id,
            'role' => $role
        ];
        $response = $this->client->post('/api/roles/remove', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function addRoleToUser($user_id, $role)
    {
        $data = [
            'user_id' => $user_id,
            'role' => $role
        ];
        $response = $this->client->post('/api/roles/assign', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createUser($data)
    {
        $response = $this->client->post('/api/register', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deleteUser(int $id)
    {
        $response = $this->client->get('/api/users/delete/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getPermissions()
    {
        $response = $this->client->get('/api/permissions', [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getPermission(int $id)
    {
        $response = $this->client->get('/api/permissions/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function updatePermission($data)
    {
        $response = $this->client->put('/api/permissions/'.$data['id'], [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createPermission($data)
    {
        $response = $this->client->post('/api/permissions', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deletePermission(int $id)
    {
        $response = $this->client->delete('/api/permissions/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getRole(int $id)
    {
        $response = $this->client->get('/api/roles/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function updateRole($data)
    {
        $response = $this->client->put('/api/roles/'.$data['id'], [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createRole($data)
    {
        $response = $this->client->post('/api/roles', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deleteRole(int $id)
    {
        $response = $this->client->delete('/api/roles/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function permissionAssignToRole($data)
    {
        $response = $this->client->post('/api/permissions/assign', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    public function removePermissionFromRole($data)
    {
        $response = $this->client->post('/api/permissions/remove', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('token')
            ]
        ]);
        return json_decode($response->getBody(), true);
    }
}
