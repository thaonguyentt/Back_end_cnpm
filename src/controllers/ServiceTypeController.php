<?php

require_once ('src/services/ServiceTypeService.php');

class ServiceTypeController
{

    public static function getAllTypeID()
    {
        $listType = ServiceTypeService::getAllServiceType();
        $listTypeID = array();
        foreach ($listType as $type) {
            $type_id = $type->getTypeID();
            array_push($listTypeID, $type_id);
        }
        var_dump($listTypeID);
        return $listTypeID;
    }

    public static function getAllServiceType() {
        $serviceType = ServiceTypeService::getAllServiceType();

        echo json_encode($serviceType);
    }

    public static function createnewType() {

        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $name = $input['name'];
        $price = $input['price'];
        $unit = $input['unit'];


        $newId = ServiceTypeService::createServiceType(
            $name,
            $price,
            $unit
        );

        echo ServiceType::findServiceTypeByID($newId)->serialize();

    }

    public static function editServiceType($type_id) {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $name = $input['name'];
        $price = $input['price'];
        $unit = $input['unit'];


        $editedServiceType = ServiceTypeService::editServiceType($type_id, $name, $price, $unit);
        echo $editedServiceType->serialize();
    }

    public static function deleteServiceType($type_id) {
        ServiceTypeService::deleteServiceType($type_id);
    }
}