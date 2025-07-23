<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/admin-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Homepage</title>
  <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>
<h2>Hello, Admin <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
<p>You're logged in with <strong>administrator access</strong>.</p>
<p>Manage users, tasks, or system settings below:</p>

<?php include '../../includes/admin-sidebar.php'; ?>

</body>
</html>