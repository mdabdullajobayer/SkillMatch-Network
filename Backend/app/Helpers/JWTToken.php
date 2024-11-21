<?php

namespace App\Helpers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    private static $secrate = 'fVBEuytIyTrXQNx3swtnFpqKg';
    public static function CreateToken($userEmail, $userId, $role, $expiry = 3600): String
    {
        $key = self::$secrate;
        if (!$key) {
            throw new Exception('JWT_SKEY is not set in the .env file.');
        }

        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + $expiry,
            'UserEmail' => $userEmail,
            'userId' => $userId,
            'Role' => $role,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function CreateTokenForSetPassword($userEmail, $expiry = 3600): String
    {
        $key = self::$secrate;
        if (!$key) {
            throw new Exception('JWT_SKEY is not set in the .env file.');
        }

        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + $expiry,
            'UserEmail' => $userEmail,
            'userId' => '0',
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token, $requiredRole = null): String|object
    {
        try {
            if (!$token) {
                return 'Unauthorized: Null Token';
            }

            $key = self::$secrate;
            if (!$key) {
                throw new Exception('JWT_SKEY is not set in the .env file.');
            }

            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Validate Token Expiry
            if ($decoded->exp < time()) {
                return 'Unauthorized: Token Expired';
            }

            // Check Role if required
            if ($requiredRole && $decoded->Role !== $requiredRole) {
                return 'Unauthorized: Insufficient Role';
            }

            return $decoded;
        } catch (Exception $e) {
            return 'Unauthorized: ' . $e->getMessage();
        }
    }
}
