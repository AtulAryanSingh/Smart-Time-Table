<?php require_once __DIR__ . '/../../../app/bootstrap.php';
require_admin();
$name = trim($_POST['name'] ?? '');
$capacity = (int)($_POST['capacity'] ?? 0);
if ($name === '' || $capacity <= 0) fail('Valid name and capacity required');
$pdo = db();
$stmt = $pdo->prepare('INSERT INTO rooms (name, capacity) VALUES (?, ?)');
$stmt->execute([$name, $capacity]);
ok(['id' => (int)$pdo->lastInsertId()]);
