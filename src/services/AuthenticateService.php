<?php

require_once ('src/model/User.php');
require_once ('src/utils/JwtUtils.php');

class AuthenticateService {

    // Prevent instantiation
    private function __construct() {}

    /**
     * @throws Exception
     */
    public static function authenticateUser(string $rawUsername, string $rawPassword) {
        $user = User::findByUsername($rawUsername);
        if (is_null($user)) {
            throw new Exception('Invalid username or password',401);
        }
        $storedHashedPassword = $user->getHashedPassword();


        if (!password_verify($rawPassword,$storedHashedPassword)) {
            throw new Exception('Invalid username or password',401);
        }

        $is_admin = $user->getIsAdmin();
        $id = $user->getId();

        // Authenticate successful
        $jwt = genJwt($id, $rawUsername, $is_admin);
        return "{\"token\":\"$jwt\"}";
    }

}