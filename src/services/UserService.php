<?php

require_once('src/model/User.php');

class UserService
{

    // Prevent instantiation
    private function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function getUserById($userId): ?User
    {
        if (!is_numeric($userId)) {
            throw new Exception('User ID is not a number');
        }
        if ((int)$userId < 1) {
            throw new Exception('User ID is less than zero');
        }

        $user = User::findById($userId);
        if (is_null($user)) {
            return null;
        }

        return $user;

    }

    /**
     * @throws Exception
     */
    public static function createUser(
        $username,
        $first_name,
        $last_name,
        $email,
        $phone_number,
        $address,
        $password
    )
    {
        if (strlen($username) < 1) {
            throw new Exception ('username is invalid');
        }
        if (strlen($first_name) < 1) {
            throw new Exception ('first name is invalid');
        }
        if (strlen($last_name) < 1) {
            throw new Exception ('last name is invalid');
        }
        if (strlen($email) < 1
            || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception ('email is invalid');
        }
        if (strlen($phone_number) < 1
            || !preg_match("/^(0[0-9]{9})|([1-9][0-9]{8})$/", $phone_number)) {
            throw new Exception('phone number is invalid');
        }
        if (strlen($address) < 1) {
            throw new Exception('address is invalid');
        }
        if (strlen($password) < 1) {
            throw new Exception('password cannot be blank');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = User::newInstance(
            $username,
            $email,
            $first_name,
            $last_name,
            $address,
            $phone_number,
            $hashedPassword
        );

        $newId = $user->saveNew();

        return $newId;
    }

    public static function editUser(
        $id,
        $first_name,
        $last_name,
        $email,
        $phone_number,
        $address,
        $password
    ): ?User
    {
        $user = User::findById($id);
        if (is_null($user)) {
            throw new Exception("No user with id {$id} found");
        }

        if ($first_name) {
            $user->setFirstName($first_name);
        }
        if ($last_name) {
            $user->setLastName($last_name);
        }
        if ($email) {
            $user->setEmail($email);
        }
        if ($phone_number) {
            $user->setPhoneNumber($phone_number);
        }
        if ($address) {
            $user->setAddress($address);
        }
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setHashedPassword($hashedPassword);
        }

        $user->saveEdit();

        $editedUser = User::findById($id);

        return $editedUser;
    }

    public static function deleteUser($id) {
        if (!is_numeric($id)) {
            throw new Exception('User ID is not a number');
        }
        if ((int)$id < 1) {
            throw new Exception('User ID is less than zero');
        }

        User::deleteUserById($id);
    }

}