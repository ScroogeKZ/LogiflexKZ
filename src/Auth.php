<?php

namespace App;

class Auth {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
    }
    
    public static function login($userId) {
        self::startSession();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['user_id'] = $userId;
    }
    
    public static function logout() {
        self::startSession();
        session_destroy();
    }
    
    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            header('Location: /admin/login.php');
            exit;
        }
    }
}