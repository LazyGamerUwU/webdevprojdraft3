<?php
session_start();
require 'database.class.php';

class Authenticator {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return true;
        }
        return false;
    }

    public function is_logged_in() {
        return isset($_SESSION['user']);
    }

    public function getUserRole($username) {
        // Query to get the user role
        $stmt = $this->pdo->prepare("SELECT role FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch();

        return $result ? $result['role'] : null;
    }

}

// Instantiate the authenticator for reuse
$auth = new Authenticator($pdo);
?>
