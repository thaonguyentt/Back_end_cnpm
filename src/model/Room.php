<?php

require_once('src/model/db.php');
require_once ('src/model/ServiceType.php');

class Room implements JsonSerializable
{

    private string $room_code;
    private string $num_people;
    private string $area;
    private string $price;
    private string $description;
    private string $room_name;
    private string $link_image;
    private array $service;

    public function __construct()
    {
    }

    public static function newInstance(string $room_code, string $num_people, string $area, string $price, string $description, string $room_name, string $link_image)
    {
        $room = new Room();
        $room->room_code = $room_code;
        $room->num_people = $num_people;
        $room->area = $area;
        $room->price = $price;
        $room->description = $description;
        $room->room_name = $room_name;
        $room->link_image = $link_image;

        return $room;
    }

    /**
     * @param array $service
     */
    public function setService(array $service): void
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->area = $area;
    }


    /**
     * @return string
     */
    public function getRoomCode(): string
    {
        return $this->room_code;
    }

    /**
     * @param string $code_room
     */
    public function setRoomCode(string $room_code): void
    {
        $this->room_code = $room_code;
    }

    /**
     * @return string
     */
    public function getNumPeople(): string
    {
        return $this->num_people;
    }

    /**
     * @param string $num_people
     */
    public function setNumPeople(string $num_people): void
    {
        $this->num_people = $num_people;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getNameRoom(): string
    {
        return $this->name_room;
    }

    /**
     * @param string $name_room
     */
    public function setRoomName(string $room_name): void
    {
        $this->room_name = $room_name;
    }

    /**
     * @return string
     */
    public function getLinkImage(): string
    {
        return $this->link_image;
    }

    /**
     * @param string $link_image
     */
    public function setLinkImage(string $link_image): void
    {
        $this->link_image = $link_image;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function serialize(): string
    {
        return json_encode($this);
    }

    //find services for each room
    public static function findAllService ($room_code): array
    {
       return ServiceType::findServiceByRoomCode($room_code);
    }

    private static function findRoomByDay_getAll( string $check_in, string $check_out, string $num_people): ?array
    {
//        if (!$check_in) {
//            throw new Exception('No checkin code given');
//        }
//        if (!$check_out) {
//            throw new Exception('No checkout code given');
//        }
//        if (!$num_people) {
//            throw new Exception('No num_people code given');
//        }

        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT r.room_code, num_people, area, price, description, room_name , link_image 
                                           from room r
                                            where r.room_code not in 
                                                (select b.room_code from book b
                                                 where (b.check_in <= :check_in1 and b.check_out >= :check_in2)
                                                 or(b.check_in <= :check_out1 and b.check_out >= :check_out2)
                                                 or(b.check_in >= :check_in3 and b.check_out <= :check_out3)
                                                ) and r.num_people = :num_people');
            $query->bindParam(':check_in1', $check_in, PDO::PARAM_STR);
            $query->bindParam(':check_out1', $check_out, PDO::PARAM_STR);
            $query->bindParam(':check_in2', $check_in, PDO::PARAM_STR);
            $query->bindParam(':check_out2', $check_out, PDO::PARAM_STR);
            $query->bindParam(':check_in3', $check_in, PDO::PARAM_STR);
            $query->bindParam(':check_out3', $check_out, PDO::PARAM_STR);
            $query->bindParam(':num_people', $num_people, PDO::PARAM_STR);

            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            }

            $returnedRow = $query->fetchAll(PDO::FETCH_ASSOC);
            $listRoom = array();
            foreach ($returnedRow as $item) {

                $foundRoom = new Room();
                $foundRoom->room_code = $item['room_code'];
                $foundRoom->num_people = $item['num_people'];
                $foundRoom->area = $item['area'];
                $foundRoom->price = $item['price'];
                $foundRoom->description = $item['description'];
                $foundRoom->room_name = $item['room_name'];
                $foundRoom->link_image = $item['link_image'];

                array_push($listRoom, $foundRoom);
            }


            $pdo->commit();
            foreach ($listRoom as $room) {
                $room->service = self::findAllService($room->getRoomCode());
            }
//
            return $listRoom;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findRoomByRoomDay($check_in, $check_out, $num_people): ?array
    {
        return self::findRoomByDay_getAll($check_in, $check_out, $num_people);
    }

    //all information of a room find by code room

    /**
     * @throws Exception
     */
    private static function findByRoomCode_getAll(string $room_code): ?Room
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT room_code, num_people, area, price, description, room_name , link_image from room where room_code = :room_code');
            $query->bindParam(':room_code', $room_code, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 user found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundRoom = new Room();
            $foundRoom->room_code = $returnedRow['room_code'];
            $foundRoom->num_people = $returnedRow['num_people'];
            $foundRoom->area = $returnedRow['area'];
            $foundRoom->price = $returnedRow['price'];
            $foundRoom->description = $returnedRow['description'];
            $foundRoom->room_name = $returnedRow['room_name'];
            $foundRoom->link_image = $returnedRow['link_image'];



            $pdo->commit();
            $foundRoom->service = self::findAllService($room_code);

            return $foundRoom;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findRoomByRoomCode($room_code): ?Room
    {
        return self::findByRoomCode_getAll($room_code);
    }


    //find and show all room from table room
    /**
     * @throws Exception
     */

    private static function findRoom_getall(): array
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT * from room');
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $listRoom = array();
            foreach ($result as $item) {
                
                $foundRoom = new Room();
                $foundRoom->room_code = $item['room_code'];
                $foundRoom->num_people = $item['num_people'];
                $foundRoom->area = $item['area'];
                $foundRoom->price = $item['price'];
                $foundRoom->description = $item['description'];
                $foundRoom->room_name = $item['room_name'];
                $foundRoom->link_image = $item['link_image'];
                $foundRoom->service = [];

                array_push($listRoom, $foundRoom);
            }

            $pdo->commit();
            return $listRoom;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findAllRoom(): ?array
    {
        return self::findRoom_getall();
    }

    //add new room

    public function saveNew(): string
    {

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint


        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('INSERT into room (room_code, num_people, area, price, description, room_name, link_image) values (:room_code, :num_people, :area, :price, :description, :room_name, :link_image)');
            $query->bindParam(':room_code', $this->room_code, PDO::PARAM_STR);
            $query->bindParam(':num_people', $this->num_people, PDO::PARAM_STR);
            $query->bindParam(':area', $this->area, PDO::PARAM_STR);
            $query->bindParam(':price', $this->price, PDO::PARAM_STR);
            $query->bindParam(':description', $this->description, PDO::PARAM_STR);
            $query->bindParam(':room_name', $this->room_name, PDO::PARAM_STR);
            $query->bindParam(':link_image', $this->link_image, PDO::PARAM_STR);
            $query->execute();

//            $newRoom = $pdo->lastInsertId();

            $pdo->commit();
            return $this->getRoomCode();
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    //edit a room by id
    public function saveEdit(): string
    {

        if (is_null($this->room_code)) {
            throw new Exception('Cannot save edit without code room');
        }

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('UPDATE room SET num_people=:num_people, area=:area, price=:price, description=:description, room_name=:room_name, link_image=:link_image WHERE room_code=:room_code');
            $query->bindParam(':room_code', $this->room_code, PDO::PARAM_STR);
            $query->bindParam(':num_people', $this->num_people, PDO::PARAM_STR);
            $query->bindParam(':area', $this->area, PDO::PARAM_STR);
            $query->bindParam(':price', $this->price, PDO::PARAM_STR);
            $query->bindParam(':description', $this->description, PDO::PARAM_STR);
            $query->bindParam(':room_name', $this->room_name, PDO::PARAM_STR);
            $query->bindParam(':link_image', $this->link_image, PDO::PARAM_STR);
            $query->execute();


            $pdo->commit();
//            var_dump($this->room_name);
            return $this->getRoomCode();
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }


    //delete a room by id


    public static function deleteRoomByRoomCode($room_code) {
        if (!$room_code) {
            throw new Exception('No room code given');
        }
        if (!self::findRoomByRoomCode($room_code)) {
            throw new Exception("No room with room code ${room_code}");
        }

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('DELETE from room where room_code=:room_code');
            $query->bindParam(':room_code', $room_code, PDO::PARAM_STR);
            $query->execute();

            $deletedRowCount = $query->rowCount();

            $pdo->commit();

            if ($deletedRowCount == 0) {
                throw new Exception('No room was deleted');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }



}