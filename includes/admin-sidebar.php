<?php
if (!isset($_SESSION)) session_start();
$role = $_SESSION['role'] ?? 'user';
?>

<style>

  :root {
    --sidebar-bg: #ffffff;
    --hover-bg: #8fbae6;
    --active-bg: #3399ff;
    --text-dark: #202020;
    --icon-color: #000000;
    
    --border-color: #e0e0e0;
    --border-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);

  }

  body.dark #sidebar {
  background-color: #181818;
}

  #sidebar {
    background-color: var(--sidebar-bg);
    width: 250px;
    height: 100vh;
    transition: width 0.3s ease;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }


  #sidebar h2 {
    font: italic 700 22px 'Poppins', sans-serif;
    color: var(--text-dark);
  }

  #sidebar .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 1.2rem;
    margin-bottom: 2rem;
  }

  #sidebar img {
    width: 35px;
    border-radius: 10%;
    object-fit: cover;
    cursor: pointer;
  }

  .sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 1.5rem;
    margin: 0.3rem 1rem;
    color: var(--text-color);
    border-radius: 12px;
    transition: all 0.2s ease-in-out;
    font-size: 15px;
  }

  .sidebar-link i {
    color: var(--icon-color);
  }

  .sidebar-link:hover {
    background-color: var(--hover-bg);
    transform: translateX(4px);
  }

  .sidebar-link.active {
    background-color: var(--active-bg);
    font-weight: 600;
  }

  #sidebar ul , a{
    list-style: none;
    text-decoration: none;
    padding: 0;
    gap: 0.5rem;
  }

  .logout-btn {
    margin: 1rem;
    color: #e53935;
    background-color: #fdecea;
    border-radius: 12px;
    padding: 10px 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background 0.3s ease;
  }

  .rotate {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
  }
  
  .sidebar-link i.fa-caret-down {
    transition: transform 0.3s ease;
  }


  .logout-btn:hover {
    background-color: #fcd8d5;
  }

  .sidebar-footer {
    margin-top: auto;
    padding: 1rem;
    border-top: 1px solid var(--border-color);
    text-align: center;
  }

  .sidebar-footer img {
    width: 40px;
    border-radius: 50%;
  }

  .sidebar-footer p {
    font-size: 13px;
    margin-top: 0.5rem;
    color: #666;
  }

  #sidebar.collapsed {
    width: 80px;
  }

  .logo h2 {
    transition: opacity 0.3s ease;
  }

  #sidebar.collapsed .logo h2,
  #sidebar.collapsed .sidebar-link span,
  #sidebar.collapsed .logout-btn span,
  #sidebar.collapsed .sidebar-footer p {
    display: none;
  }

  .sidebar-link i,
  .logout-btn i {
    font-size: 15px;
  }

  #sidebar.collapsed img {
    width: 40px;
  }

  .sidebar-footer {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .sidebar-footer img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
  }

  .toggle-collapse {
    background: none;
    border: none;
    font-size: 18px;
    color: var(--text-dark);
    padding: 10px;
    cursor: pointer;
    align-self: flex-end;
    transition: transform 0.3s;
  }

  .toggle-collapse:hover {
    transform: scale(1.1);
  }

  #sidebar.collapsed .sidebar-link{
    justify-content: center;
  }
  
  #sidebar.collapsed .logout-btn {
    justify-content: center;
    padding: 12px;
  }

  #sidebar.hide ~ #content {
	width: calc(100% - 60px);
	left: 60px;
}

@media (max-width: 1024px) {
  #sidebar {
    width: var(--sidebar-collapsed-width);
  }

  #content {
    margin-left: var(--sidebar-collapsed-width);
  }

  #main-header {
    left: var(--sidebar-collapsed-width);
  }
}

/* Mobile Landscape */
@media (max-width: 768px) {
  #sidebar {
    position: fixed;
    left: -100%;
    top: 0;
    height: 100%;
    z-index: 40;
    background-color: var(--bg-light);
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    transition: left var(--transition-speed) ease;
  }

  #sidebar.mobile-open {
    left: 0;
  }

  #overlay {
    display: block !important;
  }

  #content {
    margin-left: 0;
  }

  #main-header {
    left: 0;
  }
}

/* Mobile Portrait */
@media (max-width: 480px) {
  .user-info {
    display: none;
  }

  .search-bar {
    display: none;
  }

  #main-content {
    padding: 1rem;
  }

  .user-profile img {
    width: 36px;
    height: 36px;
  }
}

</style>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 bg-white h-full transition-all duration-500 ease-in-out w-[250px]">
  <div class="logo" onclick="toggleSidebar()">
    <img src="../../Logo-TQ.png" alt="Logo">
    <h2 class="m-0">TaskQueya</h2>
  </div>

  <ul>
    <li><a href="dashboard.php" class="sidebar-link"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>

    <?php if ($role === 'admin'): ?>
      <!-- Task Management -->
      <li>
        <a href="#" class="sidebar-link" onclick="toggleDropdown('taskDropdown')">
          <i class="fas fa-tasks"></i> <span>Task Management</span> <i class="fa-solid fa-caret-down"></i>
        </a>
        <ul id="taskDropdown" style="display: none; margin-left: 1rem;">
          <li><a href="overall-tasks.php" class="sidebar-link">Overall Tasks</a></li>
          <li><a href="due-tasks.php" class="sidebar-link">Tasks Due Soon</a></li>
          <li><a href="manage-tasks.php" class="sidebar-link">All Tasks</a></li>
        </ul>
      </li>

      <!-- User Management -->
      <li>
        <a href="#" class="sidebar-link" onclick="toggleDropdown('userDropdown')">
          <i class="fas fa-users"></i> <span>User Management</span> <i class="fa-solid fa-caret-down"></i>
        </a>
        <ul id="userDropdown" style="display: none; margin-left: 1rem;">
          <li><a href="registered-users.php" class="sidebar-link">Registered Users</a></li>
          <li><a href="add-user.php" class="sidebar-link">Add User</a></li>
        </ul>
      </li>

      <!-- Settings -->
      <li>
        <a href="#" class="sidebar-link" onclick="toggleDropdown('settingsDropdown')">
          <i class="fas fa-cogs"></i> <span>Settings</span> <i class="fa-solid fa-caret-down"></i>
        </a>
        <ul id="settingsDropdown" style="display: none; margin-left: 1rem;">
          <li><a href="edit-homepage.php" class="sidebar-link">Edit Homepage</a></li>
          <li><a href="system-settings.php" class="sidebar-link">System Settings</a></li>
          <li><a href="notification-settings.php" class="sidebar-link">Notifications</a></li>
        </ul>
      </li>

      <!-- Reports -->
      <li><a href="reports.php" class="sidebar-link"><i class="fas fa-chart-line"></i> <span>Reports</span></a></li>

    <?php else: ?>
      <!-- User Sidebar -->
      <li><a href="my-tasks.php" class="sidebar-link"><i class="fas fa-user-check"></i> <span>My Tasks</span></a></li>
      <li><a href="notifications.php" class="sidebar-link"><i class="fas fa-bell"></i> <span>Notifications</span></a></li>
      <li><a href="profile.php" class="sidebar-link"><i class="fas fa-user-circle"></i> <span>Profile</span></a></li>
    <?php endif; ?>
  </ul>

  <a href="../auth/admin-login.php" class="logout-btn">
    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
  </a>

  <div class="sidebar-footer">
    <img src="../../path/to/admin-photo.jpg" alt="Admin Photo">
    <p>Welcome back,<br><?= htmlspecialchars($_SESSION['name']) ?> <strong><?= ucfirst($role) ?></strong></p>
  </div>
</aside>



<script src="../assets/js/admin.js"></script>
