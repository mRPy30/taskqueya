<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

session_start();
$userModel = new User($pdo);

// Handle Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user'; // Default

    try {
        $success = $userModel->register($name, $email, $password, $role);
        if ($success) {
            header("Location: ../views/auth/login.php?success=1");
            exit;
        }
    } catch (Exception $e) {
        header("Location: ../views/auth/signup.php?error=1");
        exit;
    }
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login_type = $_POST['login_type'] ?? 'user';

    $user = $userModel->login($email, $password);

    if ($user) {
        if ($login_type === 'admin' && $user['role'] !== 'admin') {
            header("Location: ../views/auth/admin-login.php?error=unauthorized");
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../views/admin-dashboard.php");
        } else {
            header("Location: ../views/task-list.php");
        }
        exit;
    } else {
        $redirect = $login_type === 'admin' ? 'admin-login.php' : 'login.php';
        header("Location: ../views/auth/$redirect?error=1");
        exit;
    }
}

?>
