<?php

require_once('vendor/autoload.php');
require_once('src/services/AuthenticateService.php');

class AuthenticateController {

    public static function authenticateUser() {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $username = $input['username'];
        $password = $input['password'];

        $jwt = AuthenticateService::authenticateUser($username, $password);
        echo $jwt;
    }
}


