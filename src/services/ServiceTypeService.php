<?php

require_once('src/model/ServiceType.php');

class ServiceTypeService
{



    public static function getAllServiceType(): ?array
    {
        $serviceType = ServiceType::findAllServiceType();

        return $serviceType;

    }

    public static function createServiceType(
        $name,
        $price,
        $unit

    )
    {
//        if(Room::findProductByRoomCode($room_code)) {
//            throw new Exception('this serviceType is already existed');
//        }

        if (strlen($name) < 1) {
            throw new Exception ('name is invalid');
        }
        if (strlen($price) < 1) {
            throw new Exception ('price is invalid');
        }
        if (strlen($unit) < 1) {
            throw new Exception ('unit is invalid');
        }

        $serviceType = ServiceType::newInstance(
            $name,
            $price,
            $unit,
        );

        $newTypeID = $serviceType->saveNew();

        return $newTypeID;
    }

    public static function editServiceType(
        $type_id,
        $name,
        $price,
        $unit
    ): ?ServiceType
    {
        $serviceType = ServiceType::findServiceTypeByID($type_id);
        if (is_null($serviceType)) {
            throw new Exception("No Service with id {$type_id} found");
        }

        if ($name) {
            $serviceType->setName($name);
        }
        if ($price) {
            $serviceType->setPrice($price);
        }
        if ($unit) {
            $serviceType->setUnit($unit);
        }

        $serviceType->saveEdit();

        $editedServiceType = ServiceType::findServiceTypeByID($type_id);

        return $editedServiceType;
    }

    public static function deleteServiceType($type_id) {
        if (!is_numeric($type_id)) {
            throw new Exception('service ID is not a number');
        }
        if ((int)$type_id < 1) {
            throw new Exception('service ID is less than zero');
        }

        ServiceType::deleteUserById($type_id);
    }
}