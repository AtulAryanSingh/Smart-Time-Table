<?php
function current_user() {
  return $_SESSION['user'] ?? null;
}

function require_login(): void {
  if (!current_user()) {
    fail('Unauthorized', 401);
  }
}

function require_admin(): void {
  require_login();
  if (current_user()['role'] !== 'admin') {
    fail('Forbidden', 403);
  }
}

function login_user(array $user): void {
  $_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'],
    'course_id' => $user['course_id'],
  ];
}

function logout_user(): void {
  unset($_SESSION['user']);
}
