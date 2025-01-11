<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
}
