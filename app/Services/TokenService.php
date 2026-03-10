<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTime;
use Illuminate\Support\Facades\Session;

class TokenService
{
    protected $privateKey;
    protected $publicKey;
    protected $passphrase;

    public function __construct()
    {
        // Carregar chaves do arquivo .env
        $this->privateKey = file_get_contents(env('JWT_PRIVATE_KEY'));
        $this->publicKey = file_get_contents(env('JWT_PUBLIC_KEY'));
        $this->passphrase = env('JWT_PASSPHRASE', ''); // Senha opcional
    }

    /**
     * Gera um token assinado com a chave privada
     */
    public function generateToken(array $payload): string
    {
        $key = openssl_pkey_get_private($this->privateKey, $this->passphrase);
        if (!$key) {
            throw new \Exception('Chave privada inválida ou passphrase incorreta.');
        }

        // Gera o token
        return JWT::encode($payload, $key, 'RS256');
    }

    /**
     * Decodifica o token usando a chave pública
     */
    public function decodeToken(string $token)
    {
        try {
            return JWT::decode($token, new Key($this->publicKey, 'RS256'));
        } catch (\Exception $e) {
            // Lida com erros de decodificação
            return null;
        }
    }

    private function timestampParaDataHora($timestamp, $formato = 'd/m/Y H:i:s') {
        // Cria um objeto DateTime a partir do timestamp (em segundos)
        $data = new DateTime();
        $data->setTimestamp($timestamp);

        // Formata a data e hora de acordo com o formato especificado
        return $data->format($formato);
    }

    private function removerAcentuacao($string) {
        // Remove acentuação mantendo caracteres básicos
        $string = preg_replace(
            [
                '/[áàãâä]/u',
                '/[éèêë]/u',
                '/[íìîï]/u',
                '/[óòõôö]/u',
                '/[úùûü]/u',
                '/[ç]/u',
                '/[ÁÀÃÂÄ]/u',
                '/[ÉÈÊË]/u',
                '/[ÍÌÎÏ]/u',
                '/[ÓÒÕÔÖ]/u',
                '/[ÚÙÛÜ]/u',
                '/[Ç]/u'
            ],
            [
                'a',
                'e',
                'i',
                'o',
                'u',
                'c',
                'A',
                'E',
                'I',
                'O',
                'U',
                'C'
            ],
            $string
        );

        return $string;
    }

    public function getRolesAndPermissions (string $token, string $servico) {
        $userName = null;
        $userId = 0;
        $userPermissions = null;
        $userRoles = null;
        $exp = 0;
        $autorizado = false;
        $exp_timestamp = 0;
        if ($token) {
            $decoded = $this->decodeToken($token);
            if ($decoded) {
                // Acessar dados do token
                $userId = $decoded->sub ?? null;
                $userName = $decoded->name ?? null;
                $userRoles = $decoded->roles ?? null;
                $exp = $this->timestampParaDataHora($decoded->exp) ?? null;
                $exp_timestamp = $decoded->exp ?? null;
            }
            if ($exp_timestamp < time()) {
                // Token expirado
                Session::forget('token');
                Session::forget('user');
                abort(redirect()->route('auth.login'));
            }
            $userRolesArray = [];
            $userPermissionsArray = [];
            try {
                foreach ($userRoles as $role) {
                    //$userRolesArray[] = $role->name;
                    if (isset($role->permissions)) {
                        foreach ($role->permissions as $permission) {
                            $userPermissionsArray[] = strtolower($this->removerAcentuacao($permission));
                        }
                    }
                }
                if (in_array(strtolower($servico), $userPermissionsArray) || ($servico == 'dashboard' || $servico == 'profile') ) {
                    $autorizado = true;
                }
            } catch (\Exception $e) {
                redirect()->route('auth.login');
            }

        }
        $tokenDetails = [
            'exp' => $exp,
            'id' => $userId,
            'name' => $userName,
            'roles' => $userRoles
        ];
        Session::put('user', $tokenDetails);
        if ($autorizado == false) {
            abort(redirect()->route('dashboard'));
        }
    }
}
