<?php require_once __DIR__ . '/../../../app/bootstrap.php';
require_login();
ok(['user' => current_user()]);
