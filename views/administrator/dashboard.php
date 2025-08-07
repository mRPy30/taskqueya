<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/admin-login.php");
    exit;
    $role = $_SESSION['role'] ?? 'user';

}
?>
<!DOCTYPE html>
<html lang="en" class="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!--Title-->
  <link rel="short icon" href="../../Logo-TQ.png" type="x-icon">
  <title>Admin | Dashboard</title>

  <!--Css Links-->
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/font.css">

  <!-- Bootstrap first -->
  <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

  <!--Tailwind Css-->
  <link rel="stylesheet" href="../assets/css/output.css">

  <!--ICON LINKS-->
  <link rel="stylesheet" href="../../font-awesome-6/css/all.css">


</head>
<body>

<!-- Overlay for mobile -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<?php include '../../includes/admin-sidebar.php'; ?>

<!-- Main Content -->
<section id="content">
  <!-- Header -->
  <header id="main-header">
    <div>
      <h5>Dashboard</h5>
    </div>

    <div class="md:block">
      <input type="text" class="search-bar" placeholder="Search for anything..." />
    </div>

    <div class="flex items-center gap-4">
      <label for="switch-mode" class="cursor-pointer text-xl"><i class="fa-solid fa-moon"></i></label>
      <input type="checkbox" id="switch-mode">

      <div class="user-profile">
        <img src="../../admin-avatar.png" alt="Admin" />
        <div class="user-info sm:block">
          <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>
          <span class="text-xs">email</span>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Main Content -->
  <main id="main-content">
    <div class="head-title">
			<div class="left">
				<h1>Dashboard</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="#">Home</a>
					</li>
				</ul>
			</div>
			<a href="#" class="btn-download">
				<i class='bx bxs-cloud-download' ></i>
				<span class="text"><i class="fa-solid fa-cloud-arrow-down"></i> Download PDF</span>
			</a>
		</div>
  </main>
</section>

<?php include '../../includes/admin-footer.php'; ?>
<script src="../assets/js/admin.js"></script>
</body>
</html>