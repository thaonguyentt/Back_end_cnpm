<?php

require_once('src/model/db.php');

class ServiceType implements JsonSerializable
{
    private string $type_id;
    private string $name;
    private string $price;
    private string $unit;

    /**
     * @param string $unit
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }


    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getTypeId(): string
    {
        return $this->type_id;
    }

    /**
     * @param string $type_id
     */
    public function setTypeId(string $type_id): void
    {
        $this->type_id = $type_id;
    }


    public static function newInstance(string $name, string $price, string $unit)
    {
        $ServiceType = new ServiceType();
        $ServiceType->name = $name;
        $ServiceType->price = $price;
        $ServiceType->unit = $unit;


        return $ServiceType;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function serialize(): string
    {
        return json_encode($this);
    }

    private static function findServicebyid_getAll(string $type_id): ?ServiceType
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT type_id, name, price, unit from service_type where type_id = :type_id');
            $query->bindParam(':type_id', $type_id, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 service type found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundServiceType = new ServiceType();
            $foundServiceType->type_id = $returnedRow['type_id'];
            $foundServiceType->name = $returnedRow['name'];
            $foundServiceType->price = $returnedRow['price'];
            $foundServiceType->unit = $returnedRow['unit'];
            $pdo->commit();

            return $foundServiceType;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function findServiceTypeByID($type_id): ?ServiceType
    {
        return self::findServicebyid_getAll($type_id);
    }


        private static function findServiceTypebyRoomCode_getAll(string $room_code): ?array
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('select st.type_id , st.name , st.price , st.unit 
                                            from service_type st join mapping_room_service s on st.type_id = s.service_id 
                                            join room r on r.room_code = s.room_code 
                                            where r.room_code = :room_code');
            $query->bindParam(':room_code', $room_code, PDO::PARAM_STR);
            $query->execute();

            $returnedRow = $query->fetchAll(PDO::FETCH_ASSOC);
            $listServiceType = array();
            forEach($listServiceType as $service) {

                $foundService = new ServiceType();
                $foundService->type_id = $service['type_id'];
                $foundService->name = $service['name'];
                $foundService->price = $service['price'];
                $foundService->unit = $service['unit'];

                array_push($listServiceType, $foundService);
            }



            $pdo->commit();

            return $returnedRow;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findServiceByRoomCode($room_code): array
    {
        return self::findServiceTypebyRoomCode_getAll($room_code);
    }

    private static function findAllServiceType_getall(): array
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT * from service_type');
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $listService = array();
            foreach ($result as $item) {

                $foundService = new ServiceType();
                $foundService->type_id = $item['type_id'];
                $foundService->name = $item['name'];
                $foundService->price = $item['price'];
                $foundService->unit = $item['unit'];

                array_push($listService, $foundService);
            }

            $pdo->commit();


//            var_dump($listService);
            return $listService;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findAllServiceType(): ?array
    {
        return self::findAllServiceType_getall();
    }

    public function saveNew(): string
    {

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint


        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('INSERT into service_type (name, price, unit) values (:name, :price, :unit)');
            $query->bindParam(':name', $this->name, PDO::PARAM_STR);
            $query->bindParam(':price', $this->price, PDO::PARAM_STR);
            $query->bindParam(':unit', $this->unit, PDO::PARAM_STR);

            $query->execute();
            $newId = $pdo->lastInsertId();
//            $newRoom = $pdo->lastInsertId();

            $pdo->commit();
            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public function saveEdit(): string
    {

        if (is_null($this->type_id)) {
            throw new Exception('Cannot save edit without type id');
        }

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('UPDATE service_type SET name=:name, price=:price, unit=:unit WHERE type_id=:type_id');
            $query->bindParam(':type_id', $this->type_id, PDO::PARAM_STR);
            $query->bindParam(':name', $this->name, PDO::PARAM_STR);
            $query->bindParam(':price', $this->price, PDO::PARAM_STR);
            $query->bindParam(':unit', $this->unit, PDO::PARAM_STR);
            $query->execute();

            $newId = $pdo->lastInsertId();

            $pdo->commit();

            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function deleteUserById($type_id) {
        if (!$type_id) {
            throw new Exception('No id given');
        }
        if (!self::findServiceTypeByID($type_id)) {
            throw new Exception("No service with id ${type_id}");
        }

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('DELETE from service_type where type_id=:type_id');
            $query->bindParam(':type_id', $type_id, PDO::PARAM_STR);
            $query->execute();

            $deletedRowCount = $query->rowCount();

            $pdo->commit();

            if ($deletedRowCount == 0) {
                throw new Exception('No service was deleted');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }
}