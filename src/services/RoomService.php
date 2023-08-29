<?php

require_once('src/model/Room.php');
require_once ('src/model/ServiceType.php');

class RoomService
{
    private static function __constructor() {}

    public static function getAllProduct(): ?array
    {
        $listRoom = Room::findAllRoom();
        foreach ($listRoom as $room) {
            $room->setService(ServiceType::findServiceByRoomCode($room->getRoomCode()));
        }

        return $listRoom;

    }

    public static function getRoomByRoomCode($room_code): ?Room
    {
        if (!is_numeric($room_code)) {
            throw new Exception('User ID is not a number');
        }
        if ((int)$room_code < 1) {
            throw new Exception('User ID is less than zero');
        }
        $room = Room::findRoomByRoomCode($room_code);
        if (is_null($room)) {
            return null;
        }

        return $room;

    }

    public static function createRoom(
        $room_code,
        $num_people,
        $area,
        $price,
        $description,
        $room_name,
        $link_image
    )
    {
        if(Room::findProductByRoomCode($room_code)) {
            throw new Exception('this room is already existed', 409);
        }
        if (strlen($room_code) < 1) {
            throw new Exception ('room code is invalid');
        }
        if (strlen($num_people) < 1) {
            throw new Exception ('num people is invalid');
        }
        if (strlen($area) < 1) {
            throw new Exception ('area is invalid');
        }
        if (strlen($price) < 1) {
            throw new Exception ('price is invalid');
        }
        if (strlen($description) < 1) {
            throw new Exception('description is invalid');
        }
        if (strlen($room_name) < 1) {
            throw new Exception('room name is invalid');
        }
        if (strlen($link_image) < 1) {
            throw new Exception('link image cannot be blank');
        }


        $room = Room::newInstance(
            $room_code,
            $num_people,
            $area,
            $price,
            $description,
            $room_name,
            $link_image
        );



        $newCodeRoom = $room->saveNew();

        return $newCodeRoom;
    }

    public static function editRoom(
        $room_code,
        $num_people,
        $area,
        $price,
        $description,
        $room_name,
        $link_image
    ): ?Room
    {
        $room = Room::findRoomByRoomCode($room_code);
        if (is_null($room)) {
            throw new Exception("No room with room code {$room_code} found");
        }


        if ($num_people) {
            $room->setNumPeople($num_people);
        }
        if ($area) {
            $room->setArea($area);
        }
        if ($price) {
            $room->setPrice($price);
        }
        if ($description) {
            $room->setDescription($description);
        }
        if ($room_name) {
            $room->setRoomName($room_name);
        }
        if ($link_image) {
            $room->setLinkImage($link_image);
        }

        $room->saveEdit();

        $editedRoom = Room::findRoomByRoomCode($room_code);

        return $editedRoom;
    }

    public static function deleteRoom($room_code) {
        if(!Room::findProductByRoomCode($room_code)) {
            throw new Exception('this room is not exist', 409);
        }
        if (!is_numeric($room_code)) {
            throw new Exception('User room code is not a number');
        }
        if ((int)$room_code < 1) {
            throw new Exception('User room code is less than zero');
        }

        Room::deleteRoomByRoomCode($room_code);
    }

    public static function getRoomByDay($check_in, $check_out, $num_people) {

        $room = Room::findRoomByRoomDay($check_in, $check_out, $num_people);
        return $room;
    }
}