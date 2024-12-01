<?php
class Account {
    public static function is_logged_in() {
        return isset($_SESSION['user']);
    }

    public static function has_role($role) {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === $role;
    }

    public static function redirect_if_not_logged_in($role) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
            header("Location: ../account/login.php");
            exit();
        }

        if ($_SESSION['user']['role'] === 'admin') {
            return;
        }

        if ($_SESSION['user']['role'] !== $role) {
            header("Location: ../account/login.php");
            exit();
        }
    }
}
?>
