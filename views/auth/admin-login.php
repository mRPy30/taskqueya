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
<?php
if (isset($_GET['error']) && $_GET['error'] === 'unauthorized') {
    echo "<p style='color:red;'>You are not authorized to access the admin area.</p>";
} elseif (isset($_GET['error'])) {
    echo "<p style='color:red;'>Invalid email or password.</p>";
}
?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4 text-center">User Login</h3>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Account created. Please log in.</div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">Invalid email or password.</div>
                    <?php endif; ?>

                    <form method="POST" action="../../controllers/AuthController.php">
                        <input type="hidden" name="login_type" value="user">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Login as User</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="signup.php">Don’t have an account? Sign up</a><br>
                        <a href="admin-login.php">Login as Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>
</html>