<?php

namespace App;

class CsrfManager
{
    protected static $instance;

    protected function __construct()
    {
        // Garanta que a sessão esteja iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function generateToken()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function getToken()
    {
        return $_SESSION['csrf_token'] ?? null;
    }

    public static function validateToken($token)
    {
        return !empty($token) && hash_equals(self::getToken(), $token);
    }

    public static function clearToken()
    {
        unset($_SESSION['csrf_token']);
    }
}
