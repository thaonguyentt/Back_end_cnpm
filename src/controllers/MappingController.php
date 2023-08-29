<?php

require_once('src/services/MappingService.php');

class MappingController
{
    public static function getAllMapping() {
        $mapping = MappingService::getAllMapping();
        echo json_encode($mapping);
    }

    public static function createNewMapping() {

        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $service_id = $input['service_id'];
        $room_code = $input['room_code'];


        $newId = MappingService::createMapping(
            $service_id,
            $room_code
        );

        echo Mapping::findMappingByID($newId)->serialize();

    }

    public static function editMapping($mapping_id) {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $service_id = $input['service_id'];
        $room_code = $input['room_code'];


        $editedMapping = MappingService::editMapping($mapping_id, $service_id, $room_code);
        echo $editedMapping->serialize();
    }

    public static function deleteMapping($mapping_id) {
        MappingService::deleteMapping($mapping_id);
    }
}