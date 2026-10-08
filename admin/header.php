<?php
$adminUser = isset($_SESSION['user_name']) && $_SESSION['user_name'] !== '' ? $_SESSION['user_name'] : 'Admin';
?>
<header class="main-header">
    <a href="index.php" class="logo">
      <span class="logo-mini"><b>AI</b></span>
      <span class="logo-lg">
        <span class="brand-mark">AI</span>
        <span class="brand-text">
          <b>Amazing Infotech</b>
          <small>Admin Panel</small>
        </span>
      </span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="header-actions">
        <a href="../" target="_blank" rel="noopener" class="header-link">
          <i class="fa fa-external-link"></i> <span class="hidden-xs">View Website</span>
        </a>
        <span class="header-user hidden-xs">
          <span class="header-avatar"><?php echo htmlspecialchars(strtoupper(substr($adminUser, 0, 1))); ?></span>
          <span class="header-user-name"><?php echo htmlspecialchars($adminUser); ?></span>
        </span>
        <a href="logout.php" class="header-signout">
          <i class="fa fa-sign-out"></i> <span class="hidden-xs">Sign out</span>
        </a>
      </div>
    </nav>
  </header>
