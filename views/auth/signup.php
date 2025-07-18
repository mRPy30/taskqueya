<?php include '../../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="../../Logo-TQ.png" type="x-icon">
    <title>
        <?php echo "Signup Now!"; ?>
    </title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<main class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <img src="../../Logo-TQ.png" alt="Logo" class="logo-img">
            </div>

            <h2 class="title">Create your Account Now!</h2>
            <p class="subtitle">It's quick and easy</p>

            <?php if (isset($_GET['success'])) echo "<p class='msg success'>Account created. You can now login.</p>"; ?>
            <?php if (isset($_GET['error'])) echo "<p class='msg error'>Something went wrong. Try again.</p>"; ?>

            <form method="POST" action="../../controllers/AuthController.php" class="login-form">
                <div class="input-group">
                    <input type="text" name="name" id="name" required>
                    <label for="name">Full Name</label>
                </div>

                <div class="input-group">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>

                <button type="submit" name="register" class="btn-login">Sign Up</button>
            </form>

            <p class="signup-text">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </main>
</body>

<?php include '../../includes/footer.php'; ?>
</html>