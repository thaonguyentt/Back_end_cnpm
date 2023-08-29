<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @throws Exception
 */
function genJwt($id, $username, $isAdmin) {
    if (is_null($username)) {
        throw new Exception('username is null');
    }
    $key = 'somerandomkeyidontcare';
    $payload = array(
        "iss" => 'hozing',
        "iat" => time(),
        "exp" => time() + 604800, // 1 week
        "id" => $id,
        "username" => $username,
        "is_admin" => $isAdmin,
    );
    return JWT::encode($payload, $key, 'HS256');
}

/**
 * @throws Exception
 */
function allowUser() {
    $key = 'somerandomkeyidontcare';

    if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        throw new Exception('Authorization header required', 401);
    }
    $jwt = $matches[1];


    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $decoded_array = (array) $decoded;

    if ($decoded_array['exp'] < time()) {
        throw new Exception('Unauthorized',401);
    }
    $username = $decoded_array['username'];
    if (is_null($username) || strlen(trim($username)) == 0) {
        throw new Exception('Unauthorized',401);
    }
}

function allowUserWithId($id) {
    $key = 'somerandomkeyidontcare';

    if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        throw new Exception('Authorization header required', 401);
    }
    $jwt = $matches[1];


    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $decoded_array = (array) $decoded;

    if (strcmp($decoded_array['id'], $id) != 0) {
        throw new Exception('Unauthorized', 401);
    }

    if ($decoded_array['exp'] < time()) {
        throw new Exception('Unauthorized',401);
    }
    $username = $decoded_array['username'];
    if (is_null($username) || strlen(trim($username)) == 0) {
        throw new Exception('Unauthorized',401);
    }
}

/**
 * @throws Exception
 */
function allowAdmin() {
    $key = 'somerandomkeyidontcare';

    if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        throw new Exception('Authorization header required', 401);
    }
    $jwt = $matches[1];

    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $decoded_array = (array) $decoded;

    if ($decoded_array['exp'] < time()) {
        throw new Exception('Unauthorized',401);
    }
    $username = $decoded_array['username'];
    if (is_null($username) || strlen(trim($username)) == 0) {
        throw new Exception('Unauthorized',401);
    }

    $is_admin = (boolean) $decoded_array['is_admin'];
    if (!$is_admin) {
        throw new Exception('Unauthorized',401);
    }

}