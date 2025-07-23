<?php
require_once '../../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phrase = strtolower(trim($_POST['voice_phrase']));

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, voice_phrase) VALUES (?, ?, ?, 'admin', ?)");
    $stmt->execute([$name, $email, $password, $phrase]);

    echo "Admin registered successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register Admin (Voice)</title>
</head>
<body>
  <h2>Register Admin</h2>
  <form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Voice Phrase (What the admin should say to log in):</label><br>
    <input type="text" name="voice_phrase" required><br><br>

    <button type="submit">Register</button>
  </form>
</body>
</html>
