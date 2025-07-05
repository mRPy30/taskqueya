<?php include '../../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="" type="x-icon">
    <title>
        <?php echo "Signup Now!"; ?>
    </title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<?php if (isset($_GET['success'])) echo "<p>Account created. You can now login.</p>"; ?>
<?php if (isset($_GET['error'])) echo "<p style='color:red;'>Something went wrong. Try again.</p>"; ?>

<main>
    <h2>Sign Up</h2>
    <form method="POST" action="../../controllers/AuthController.php">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</main>

<?php include '../../includes/footer.php'; ?>
</html>