<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
?>

<h2>Welcome, <?= $_SESSION['name'] ?> (<?= $_SESSION['role'] ?>)</h2>
<a href="auth/logout.php">Logout</a>
