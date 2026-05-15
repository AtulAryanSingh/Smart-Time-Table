<?php
// Common bootstrap
session_start();

define('APP_ROOT', dirname(__DIR__));

$config = require APP_ROOT . '/app/config.php';

require_once APP_ROOT . '/app/db.php';
require_once APP_ROOT . '/app/response.php';
require_once APP_ROOT . '/app/auth.php';
