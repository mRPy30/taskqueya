<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/admin-login.php");
    exit;
}
?>

<h2>Hello, Admin <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
<p>You're logged in with <strong>administrator access</strong>.</p>
<p>Manage users, tasks, or system settings below:</p>

<!-- Example: Admin-only actions -->
<ul>
    <li><a href="manage-users.php">Manage Users</a></li>
    <li><a href="manage-tasks.php">View All Tasks</a></li>
</ul>

<a href="auth/logout.php">Logout</a>
