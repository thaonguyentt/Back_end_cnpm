<?php

require_once('src/model/db.php');

class User implements JsonSerializable
{

    private string $id;
    private string $username;
    private string $email;
    private ?string $first_name;
    private ?string $last_name;
    private ?string $address;
    private ?string $hashed_password;
    private ?string $phone_number;
    private bool $is_admin = false;

    private static function __constructor() {}

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @param string|null $hashed_password
     */
    public function setHashedPassword(?string $hashed_password): void
    {
        $this->hashed_password = $hashed_password;
    }

    /**
     * @param string|null $phone_number
     */
    public function setPhoneNumber(?string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }



    /**
     * @param string $username
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @param string $address
     * @param string $phone_number
     * @param string $hashed_password
     * @return User
     */
    public static function newInstance(string $username, string $email, string $first_name, string $last_name, string $address, string $phone_number, string $hashed_password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->address = $address;
        $user->phone_number = $phone_number;
        $user->hashed_password = $hashed_password;

        return $user;
    }



    /**
     * @param string $is_admin
     */
    public function setIsAdmin(string $is_admin): void
    {
        $this->is_admin = $is_admin;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


    public function serialize(): string
    {
        $serializeData = $this;
        // Loai bo hashed_password, is_admin ra khoi json
        unset($serializeData->hashed_password);
        unset($serializeData->is_admin);

        return json_encode($serializeData);
    }

    /**
     * @throws Exception
     */
    public static function deserialize($user_json_str): User
    {
        $decoded = json_decode($user_json_str);
        if (is_null($decoded)) {
            throw new Exception('Invalid user json');
        }
        $user = new User();
        $user->id = $decoded['id'];
        $user->username = $decoded['username'];
        $user->email = $decoded['email'];
        $user->first_name = $decoded['first_name'];
        $user->last_name = $decoded['last_name'];
        $user->address = $decoded['address'];
        $user->phone_number = $decoded['phone_number'];

        return $user;

    }

    public function getHashedPassword()
    {
        return $this->hashed_password;
    }

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @throws Exception
     */
    public function saveNew(): string
    {

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('INSERT into user (username, email, first_name, last_name, hashed_password, address, phone_number, is_admin) values (:username, :email, :first_name, :last_name, :hashed_password, :address, :phone_number, :is_admin)');
            $query->bindParam(':username', $this->username, PDO::PARAM_STR);
            $query->bindParam(':email', $this->email, PDO::PARAM_STR);
            $query->bindParam(':first_name', $this->first_name, PDO::PARAM_STR);
            $query->bindParam(':last_name', $this->last_name, PDO::PARAM_STR);
            $query->bindParam(':hashed_password', $this->hashed_password, PDO::PARAM_STR);
            $query->bindParam(':address', $this->address, PDO::PARAM_STR);
            $query->bindParam(':phone_number', $this->phone_number, PDO::PARAM_STR);
            $query->bindParam(':is_admin', $this->is_admin, PDO::PARAM_BOOL);
            $query->execute();

            $newId = $pdo->lastInsertId();

            $pdo->commit();

            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    /**
     * @throws Exception
     */
    public function saveEdit(): string
    {

        if (is_null($this->id)) {
            throw new Exception('Cannot save edit without id');
        }

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('UPDATE user SET email=:email, first_name=:first_name, last_name=:last_name, hashed_password=:hashed_password, address=:address, phone_number=:phone_number WHERE id=:id');
            $query->bindParam(':id', $this->id, PDO::PARAM_STR);
            $query->bindParam(':email', $this->email, PDO::PARAM_STR);
            $query->bindParam(':first_name', $this->first_name, PDO::PARAM_STR);
            $query->bindParam(':last_name', $this->last_name, PDO::PARAM_STR);
            $query->bindParam(':hashed_password', $this->hashed_password, PDO::PARAM_STR);
            $query->bindParam(':address', $this->address, PDO::PARAM_STR);
            $query->bindParam(':phone_number', $this->phone_number, PDO::PARAM_STR);
            $query->execute();

            $newId = $pdo->lastInsertId();

            $pdo->commit();

            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    /**
     * @throws Exception
     */
    private static function findById_getAll(string $id): ?User
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT id, username, email, first_name, last_name, address, email, phone_number, is_admin, hashed_password from user where id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 user found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundUser = new User();
            $foundUser->id = $returnedRow['id'];
            $foundUser->username = $returnedRow['username'];
            $foundUser->email = $returnedRow['email'];
            $foundUser->first_name = $returnedRow['first_name'];
            $foundUser->last_name = $returnedRow['last_name'];
            $foundUser->hashed_password = $returnedRow['hashed_password'];
            $foundUser->address = $returnedRow['address'];
            $foundUser->phone_number = $returnedRow['phone_number'];
            $foundUser->is_admin = (boolean)$returnedRow['is_admin'];

            $pdo->commit();

            return $foundUser;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findById($id): ?User
    {
        return self::findById_getAll($id);
    }

    /**
     * @throws Exception
     */
    private static function findByUsername_getAll(string $username): ?User
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT id, username, email, first_name, last_name, address, email, phone_number, is_admin, hashed_password from user where username = :username');
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 user found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundUser = new User();
            $foundUser->id = $returnedRow['id'];
            $foundUser->username = $returnedRow['username'];
            $foundUser->email = $returnedRow['email'];
            $foundUser->first_name = $returnedRow['first_name'];
            $foundUser->last_name = $returnedRow['last_name'];
            $foundUser->hashed_password = $returnedRow['hashed_password'];
            $foundUser->address = $returnedRow['address'];
            $foundUser->phone_number = $returnedRow['phone_number'];
            $foundUser->is_admin = (boolean)$returnedRow['is_admin'];

            $pdo->commit();

            return $foundUser;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findByUsername($username): ?User
    {
        return self::findByUsername_getAll($username);
    }

    public static function deleteUserById($id) {
        if (!$id) {
            throw new Exception('No id given');
        }
        if (!self::findById_getAll($id)) {
            throw new Exception("No user with id ${id}");
        }

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('DELETE from user where id=:id');
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();

            $deletedRowCount = $query->rowCount();

            $pdo->commit();

            if ($deletedRowCount == 0) {
                throw new Exception('No user was deleted');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }
}