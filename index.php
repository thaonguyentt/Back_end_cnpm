<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once 'vendor/autoload.php';

ini_set('display_errors', '0');

// Load environment variables (db path, username, password, ...)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

// Start routing
include('fastroute.php');



