<?php require_once __DIR__ . '/../../../app/bootstrap.php';
require_admin();
$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) fail('Valid id required');
$pdo = db();
$stmt = $pdo->prepare('DELETE FROM rooms WHERE id=?');
$stmt->execute([$id]);
ok(['deleted' => true]);
