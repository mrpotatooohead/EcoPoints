<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
$pageTitle = $pageTitle ?? 'EcoPoints';
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle) ?> | EcoPoints</title>
<link rel="stylesheet" href="assets/css/style.css">
</head><body>
<header class="topbar">
  <a class="brand" href="index.php"><span class="brand-mark">♻</span><span>Eco<span>Points</span></span></a>
  <nav>
    <?php if ($user): ?>
      <a href="dashboard.php">Dashboard</a>
      <?php if ($user['role']==='student'): ?><a href="rewards.php">Rewards</a><a href="recycle.php">Recycle</a><?php endif; ?>
      <?php if ($user['role']==='personnel'): ?><a href="claims.php">Claims</a><?php endif; ?>
      <?php if ($user['role']==='admin'): ?><a href="admin.php">Manage</a><?php endif; ?>
      <span class="nav-user"><?= htmlspecialchars($user['name']) ?></span><a class="nav-logout" href="logout.php">Log out</a>
    <?php else: ?><a href="login.php">Log in</a><a class="nav-cta" href="register.php">Create account</a><?php endif; ?>
  </nav>
</header>
<main class="container">
