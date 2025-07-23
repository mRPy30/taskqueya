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

// ✅ Handle Admin Voice Recognition Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voice_login'])) {
    $output = shell_exec("python " . __DIR__ . "/../views/auth/verify_voice.py");
    $data = json_decode($output, true);

    if ($data && $data['status'] === 'success') {
        // Get admin by email from DB
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
        $stmt->execute([$data['email']]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['name'] = $admin['name'];
            $_SESSION['role'] = $admin['role'];

            header("Location: ../views/administrator/dashboard.php");
            exit;
        } else {
            header("Location: ../views/auth/admin-login.php?error=admin_not_found");
            exit;
        }
    } else {
        header("Location: ../views/auth/admin-login.php?error=voice_not_recognized");
        exit;
    }
}

// ✅ Handle Admin Face Login from Python
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id']) && !isset($_POST['login'])) {
    $admin_id = $_POST['admin_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND role = 'admin'");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['name'] = $admin['name'];
        $_SESSION['role'] = $admin['role'];

        echo "Face login successful.";
    } else {
        http_response_code(401);
        echo "Face login failed.";
    }

    exit;
}

// Handle Email/Password Login
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
            header("Location: ../views/administrator/dashboard.php");
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
