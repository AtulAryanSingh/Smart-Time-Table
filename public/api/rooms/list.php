<?php require_once __DIR__ . '/../../../app/bootstrap.php';
require_admin();
$pdo = db();
$rows = $pdo->query('SELECT * FROM rooms ORDER BY id DESC')->fetchAll();
ok($rows);
