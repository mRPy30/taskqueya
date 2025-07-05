<?php include '../../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="" type="x-icon">
    <title>
        <?php echo "Please login your Account"; ?>
    </title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<?php if (isset($_GET['success'])) echo "<p>Account created. Please log in.</p>"; ?>
<?php if (isset($_GET['error'])) echo "<p style='color:red;'>Invalid email or password.</p>"; ?>

<main>
    <h2>Login</h2>
    <form method="POST" action="../../controllers/AuthController.php">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don’t have an account? <a href="signup.php">Sign up</a></p>
</main>

<?php include '../../includes/footer.php'; ?>
</html>