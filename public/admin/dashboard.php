<?php require_once __DIR__ . '/../../app/bootstrap.php';
$config = require APP_ROOT . '/app/config.php';
$base = $config['app']['base_url'];
$user = current_user();
if (!$user) { header('Location: ' . $base . '/auth/login.php'); exit; }
if ($user['role'] !== 'admin') { http_response_code(403); echo 'Forbidden'; exit; }
?><!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 m-0">Admin Dashboard</h1>
    <a class="btn btn-outline-secondary btn-sm" href="<?= htmlspecialchars($base) ?>/index.php">Home</a>
  </div>

  <div class="list-group">
    <a class="list-group-item list-group-item-action" href="<?= htmlspecialchars($base) ?>/admin/rooms.php">Manage Rooms</a>
  </div>
</div>
</body>
</html>
