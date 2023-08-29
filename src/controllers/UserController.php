<?php

require_once ('src/services/UserService.php');

class UserController {

    // Prevent instantiation
    private function __construct() {}

    /**
     * @throws Exception
     */
    public static function getUser($rawUserId) {
        $user = UserService::getUserById($rawUserId);
        if (is_null($user)) {
            throw new Exception('User not found', 404);
        }
        echo $user->serialize();
    }

    /**
     * @throws Exception
     */
    public static function createUser() {

        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $username = $input['username'];
        $email = $input['email'];
        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $address = $input['address'];
        $phone_number = $input['phone_number'];
        $password = $input['password'];

        $newId = UserService::createUser(
            $username,
            $first_name,
            $last_name,
            $email,
            $phone_number,
            $address,
            $password
        );

        echo UserService::getUserById($newId)->serialize();

    }

    public static function editUser($id) {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $email = $input['email'];
        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $address = $input['address'];
        $phone_number = $input['phone_number'];
        $password = $input['password'];

        $editedUser = UserService::editUser($id,$first_name,$last_name,$email,$phone_number,$address,$password);
        echo $editedUser->serialize();
    }

    public static function deleteUser($id) {
        UserService::deleteUser($id);
    }

}
