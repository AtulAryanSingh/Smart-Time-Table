<?php
function json_response($data, int $status = 200): void {
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

function ok($data = null): void {
  json_response(['success' => true, 'data' => $data]);
}

function fail(string $error, int $status = 400, $extra = null): void {
  $payload = ['success' => false, 'error' => $error];
  if ($extra !== null) {
    $payload = array_merge($payload, (array)$extra);
  }
  json_response($payload, $status);
}
