<?php require_once __DIR__ . '/../../../app/bootstrap.php';
// POST: email, password
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
  fail('Email and password are required');
}

$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user) {
  fail('Invalid credentials', 401);
}

if (!password_verify($password, $user['password_hash'])) {
  fail('Invalid credentials', 401);
}

login_user($user);
ok(['user' => current_user()]);
