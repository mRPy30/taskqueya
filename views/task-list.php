<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: auth/login.php");
    exit;
}
?>

<h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
<p>You are logged in as <strong><?= $_SESSION['role'] ?></strong>.</p>
<p>Here's your task list:</p>
<a href="auth/logout.php">Logout</a>
