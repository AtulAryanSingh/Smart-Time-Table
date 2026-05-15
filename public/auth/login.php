<?php require_once __DIR__ . '/../../app/bootstrap.php';
$config = require APP_ROOT . '/app/config.php';
$base = $config['app']['base_url'];
if (current_user()) { header('Location: ' . $base . '/index.php'); exit; }
?><!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Smart Time Table</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 520px;">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h1 class="h4 mb-3">Login</h1>
      <div id="alert"></div>
      <form id="loginForm">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" required />
        </div>
        <button class="btn btn-primary w-100" type="submit">Login</button>
      </form>
      <div class="mt-3 text-center">
        <a href="<?= htmlspecialchars($base) ?>/auth/register.php">Create account</a>
      </div>
    </div>
  </div>
</div>
<script>
const form = document.getElementById('loginForm');
const alertBox = document.getElementById('alert');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  alertBox.innerHTML = '';
  const fd = new FormData(form);
  const res = await fetch('../api/auth/login.php', { method: 'POST', body: fd });
  const json = await res.json();
  if (!json.success) {
    alertBox.innerHTML = `<div class="alert alert-danger">${json.error}</div>`;
    return;
  }
  window.location.href = '<?= htmlspecialchars($base) ?>/index.php';
});
</script>
</body>
</html>
