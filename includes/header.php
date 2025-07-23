<style>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 100px;
  border-bottom: 1px solid #ccc;
  position: relative;
}

.logo {
  font-family: 'Exo 2', sans-serif;
  font-size: 30px;
  font-style: italic;
  font-weight: bold;
  letter-spacing: 3%;
}

.auth-buttons {
  display: flex;
  gap: 10px;
}
.auth-buttons button {
  font-family: 'Poppins', sans-serif;
  font-size: 17px;
  padding: 8px 16px;
  border: 1px solid #000;
  background: transparent;
  cursor: pointer;
  border-radius: 5px;
}
.menu-toggle {
  display: none;
  font-size: 24px;
  cursor: pointer;
  background: none;
  border: none;
}

@media (max-width: 768px) {
    header{
      padding: 15px;
    }
    .menu-toggle {
      display: block;
    }
    .auth-buttons {
      flex-direction: column;
      position: absolute;
      top: 70px;
      right: 40px;
      background-color: #fff;
      padding: 10px;
      border: 1px solid #ccc;
      display: none;
    }
    .auth-buttons.show {
      display: flex;
    }
}


</style>

<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">

    <header>
        <div class="logo">TaskQueya</div>
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
        <div class="auth-buttons" id="authMenu">
          <button onclick="location.href='auth/login.php'">Login</button>
          <button onclick="location.href='auth/signup.php'">Sign up Now</button>
        </div>
    </header>

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
