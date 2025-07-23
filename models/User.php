<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($name, $email, $password, $role = 'user') {
        if (!in_array($role, ['user', 'admin'])) {
            throw new InvalidArgumentException("Invalid role");
        }

        // Hash only if role is 'user'
        $finalPassword = ($role === 'user') ? password_hash($password, PASSWORD_DEFAULT) : $password;

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $finalPassword, $role]);
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user['role'] === 'admin' && $password === $user['password']) {
                // Plain text password check for admin
                return $user;
            } elseif ($user['role'] === 'user' && password_verify($password, $user['password'])) {
                // Hashed password check for user
                return $user;
            }
        }

        return false;
    }
}
?>
