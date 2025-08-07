<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="../../Logo-TQ.png" type="x-icon">
    <title>
        <?php echo "Signup Now!"; ?>
    </title>
    <link rel="short icon" href="../../Logo-TQ.png" type="x-icon">
    <link rel="stylesheet" href="../assets/css/font.css">
</head>
<style>
    :root {
        --background-color: linear-gradient(135deg, #001E36, #004080);
        --primary-color: #007bff;
        --primary-dark: #0056b3;
        --text-color: #333;
        --bg-color: #fff;
        --shadow-color: rgba(0, 0, 0, 0.15);
        --input-border: #ccc;
        --label-color: #999;
    
        --success-bg: #d4edda;
        --success-text: #155724;
        --error-bg: #f8d7da;
        --error-text: #721c24;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: 'Segoe UI', sans-serif;
        background: var(--background-color);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    .logo-img {
        width: 80px;
        height: auto;
        object-fit: contain;
        cursor: pointer;
        border-radius: 5px;
    }
    .login-container {
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: center;
    }
    .login-card {
        background-color: var(--bg-color);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 8px 16px var(--shadow-color);
        width: 100%;
        max-width: 400px;
    }
    .title {
        font-size: 24px;
        text-align: center;
        margin-bottom: 10px;
        color: var(--text-color);
        font-family: 'Exo 2';
        font-weight: 700;
    }
    .subtitle {
        text-align: center;
        color: #666;
        margin-bottom: 20px;
    }
    .login-form .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .login-form input {
        width: 100%;
        padding: 12px 10px;
        border: 1px solid var(--input-border);
        border-radius: 12px;
        outline: none;
        transition: border 0.3s;
    }
    .login-form label {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        background: var(--bg-color);
        padding: 0 5px;
        color: var(--label-color);
        pointer-events: none;
        transition: 0.2s ease all;
    }
    .login-form input:focus + label,
    .login-form input:valid + label {
        top: -10px;
        font-size: 12px;
        color: var(--primary-color);
    }
    .btn-login {
        width: 100%;
        background-color: var(--primary-color);
        color: var(--bg-color);
        padding: 12px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-login:hover {
        background-color: var(--primary-dark);
    }
    .signup-text {
        text-align: center;
        margin-top: 1rem;
        font-size: 14px;
    }
    .signup-text a {
        color: var(--primary-color);
        text-decoration: none;
    }
    .signup-text a:hover {
        text-decoration: underline;
    }
    .msg {
        text-align: center;
        font-size: 14px;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 8px;
    }
    .msg.success {
        background-color: var(--success-bg);
        color: var(--success-text);
    }
    .msg.error {
        background-color: var(--error-bg);
        color: var(--error-text);
    }

    @media (max-width: 480px) {
        .login-card {
            padding: 1.5rem;
            border-radius: 15px;
        }
    
        .title {
            font-size: 20px;
        }
    
        .btn-login {
            font-size: 14px;
            padding: 10px;
        }
    }
</style>
<main class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <img src="../../Logo-TQ.png" alt="Logo" class="logo-img" onclick="location.href='../index.php'">
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const pwdInput = document.getElementById("password");
        
            pwdInput.addEventListener("focus", () => {
                pwdInput.setAttribute("type", "text");
            });
        
            pwdInput.addEventListener("blur", () => {
                pwdInput.setAttribute("type", "password");
            });
        });
    </script>
</body>
</html>