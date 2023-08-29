<?php

require_once('src/model/Mapping.php');

class MappingService
{
    public static function getAllMapping(): ?array
    {
        $mapping = Mapping::findAllMapping();
        return $mapping;
    }

    public static function createMapping(
        $service_id,
        $room_code

    )
    {
//        if(Room::findProductByRoomCode($room_code)) {
//            throw new Exception('this newInstanceMapping is already existed');
//        }

        if (strlen($service_id) < 1) {
            throw new Exception ('id is invalid');
        }
        if (strlen($room_code) < 1) {
            throw new Exception ('room_code is invalid');
        }

        $newInstanceMapping = Mapping::newInstance(
            $service_id,
            $room_code
        );

        $newMappingID = $newInstanceMapping->saveNew();

        return $newMappingID;
    }

    public static function editMapping(
        $mapping_id,
        $service_id,
        $room_code
    ): ?Mapping
    {
        $editingMapping = Mapping::findMappingByID($mapping_id);
        if (is_null($editingMapping)) {
            throw new Exception("No Mapping with id {$mapping_id} found");
        }

        if ($service_id) {
            $editingMapping->setServiceId($service_id);
        }
        if ($room_code) {
            $editingMapping->setRoomCode($room_code);
        }

        $editingMapping->saveEdit();

        $editedMapping = Mapping::findMappingByID($mapping_id);

        return $editedMapping;
    }

    public static function deleteMapping($mapping_id) {
        if (!is_numeric($mapping_id)) {
            throw new Exception('mapping ID is not a number');
        }
        if ((int)$mapping_id < 1) {
            throw new Exception('mapping ID is less than zero');
        }

        Mapping::deleteMappingById($mapping_id);
    }
}