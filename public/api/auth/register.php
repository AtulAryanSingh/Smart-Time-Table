<?php require_once __DIR__ . '/../../../app/bootstrap.php';
// POST: name, email, password
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $password === '') {
  fail('All fields are required');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  fail('Invalid email');
}

$pdo = db();
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
  fail('Email already registered');
}

$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, "student")');
$stmt->execute([$name, $email, $hash]);

ok(['message' => 'Registered']);
