<?php require_once __DIR__ . '/../../app/bootstrap.php';
$config = require APP_ROOT . '/app/config.php';
$base = $config['app']['base_url'];
logout_user();
header('Location: ' . $base . '/index.php');
exit;
