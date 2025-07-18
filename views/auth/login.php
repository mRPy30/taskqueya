<?php include '../../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="short icon" href="../../Logo-TQ.png" type="x-icon">
    <title><?php echo "Please login your Account"; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <main class="login-container">
        <div class="login-card">
            <div class="logo-container">
            <img src="../../Logo-TQ.png" alt="Logo" class="logo-img">
            </div>

            <h2 class="title">Hello User!</h2>
            <p class="subtitle">Please login to your account</p>

            <?php if (isset($_GET['success'])) echo "<p class='msg success'>Account created. Please Log in.</p>"; ?>
            <?php if (isset($_GET['error'])) echo "<p class='msg error'>Invalid email or password.</p>"; ?>

            <form method="POST" action="../../controllers/AuthController.php" class="login-form">
                <div class="input-group">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>

                <input type="hidden" name="login_type" value="user">
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>

            <p class="signup-text">Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </main>

    <script src="../assets/js/login.js"></script>
</body>
<?php include '../../includes/footer.php'; ?>
</html>
