<?php require_once __DIR__ . '/../app/bootstrap.php';
$config = require APP_ROOT . '/app/config.php';
$base = $config['app']['base_url'];
$user = current_user();
?><!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Smart Time Table</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= htmlspecialchars($base) ?>/index.php">Smart Time Table</a>
    <div class="ms-auto">
      <?php if ($user): ?>
        <span class="navbar-text text-white me-3">Hello, <?= htmlspecialchars($user['name']) ?></span>
        <a class="btn btn-outline-light btn-sm" href="<?= htmlspecialchars($base) ?>/auth/logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light btn-sm me-2" href="<?= htmlspecialchars($base) ?>/auth/login.php">Login</a>
        <a class="btn btn-light btn-sm" href="<?= htmlspecialchars($base) ?>/auth/register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="p-4 bg-white rounded shadow-sm">
    <h1 class="h3">University Timetable</h1>
    <p class="text-muted mb-4">A realistic full-stack PHP + MySQL project with JSON APIs.</p>

    <?php if (!$user): ?>
      <p>Please login to view the timetable.</p>
    <?php else: ?>
      <?php if ($user['role'] === 'admin'): ?>
        <a class="btn btn-primary" href="<?= htmlspecialchars($base) ?>/admin/dashboard.php">Go to Admin Dashboard</a>
      <?php else: ?>
        <a class="btn btn-primary" href="<?= htmlspecialchars($base) ?>/student/timetable.php">View My Timetable</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
