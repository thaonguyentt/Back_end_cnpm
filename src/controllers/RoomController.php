<?php

require_once('src/services/RoomService.php');

class RoomController {
    private function __construct() {}


    public static function getOneRoom($rawRoomCode) {
        $room = RoomService::getRoomByRoomCode($rawRoomCode);
        $array_ = $room->serialize();

        echo $array_;
    }

    public static function getAllRoomCode()
    {
        $listRoom = RoomService::getAllProduct();
        $listRoomCode = array();
        foreach ($listRoom as $room) {
            $room_code = $room->getRoomCode();
            array_push($listRoomCode, $room_code);
        }
        var_dump($listRoomCode);
        return $listRoomCode;
    }


    /**
     * @throws Exception
     */
    public static function getAllRoom() {
        $product = RoomService::getAllProduct();

        echo json_encode($product);
    }

    public static function createRoom() {

        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $room_code = $input['room_code'];
        $num_people = $input['num_people'];
        $area = $input['area'];
        $price = $input['price'];
        $description = $input['description'];
        $room_name = $input['room_name'];
        $link_image = $input['link_image'];

        $newCodeRoom = RoomService::createRoom(
            $room_code,
            $num_people,
            $area,
            $price,
            $description,
            $room_name,
            $link_image
        );

        echo RoomService::getRoomByRoomCode($newCodeRoom)->serialize();

    }

    public static function editRoom($room_code) {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $num_people = $input['num_people'];
        $area = $input['area'];
        $price = $input['price'];
        $description = $input['description'];
        $room_name = $input['room_name'];
        $link_image = $input['link_image'];

        $editedRoom = RoomService::editRoom(
            $room_code,
            $num_people,
            $area,
            $price,
            $description,
            $room_name,
            $link_image
        );
        echo $editedRoom->serialize();
    }

    public static function deleteRoom($room_code) {

        RoomService::deleteRoom($room_code);
    }
    public static function getAllRoomByDay() {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $check_in = $input['check_in'];
        $check_out = $input['check_out'];
        $num_people = $input['num_people'];

        $listRoom = RoomService::getRoomByDay($check_in, $check_out, $num_people);
        echo json_encode($listRoom);
    }
}
