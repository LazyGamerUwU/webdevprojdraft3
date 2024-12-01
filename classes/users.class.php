<?php
require 'students.php';

function get_users() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, username, role FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_user($username, $password, $role) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $hashed_password, $role]);
}

function delete_user($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}
?>
