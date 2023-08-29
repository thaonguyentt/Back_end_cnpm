<?php

require_once('src/model/db.php');

class Mapping implements JsonSerializable
{
    private string $mapping_id;
    private string $service_id;
    private string $room_code;

    /**
     * @return string
     */
    public function getMappingId(): string
    {
        return $this->mapping_id;
    }

    /**
     * @param string $mapping_id
     */
    public function setMappingId(string $mapping_id): void
    {
        $this->mapping_id = $mapping_id;
    }


    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->service_id;
    }

    /**
     * @param string $service_id
     */
    public function setServiceId(string $service_id): void
    {
        $this->service_id = $service_id;
    }

    /**
     * @return string
     */
    public function getRoomCode(): string
    {
        return $this->room_code;
    }

    /**
     * @param string $room_code
     */
    public function setRoomCode(string $room_code): void
    {
        $this->room_code = $room_code;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function serialize(): string
    {
        return json_encode($this);
    }

    public static function newInstance(string $service_id, string $room_code)
    {
        $mapping = new Mapping();
        $mapping->service_id = $service_id;
        $mapping->room_code = $room_code;
        return $mapping;
    }

    private static function findMappingbyid_getAll(string $mapping_id): ?Mapping
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT mapping_id, service_id, room_code from mapping_room_service where mapping_id = :mapping_id');
            $query->bindParam(':mapping_id', $mapping_id, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 mapping found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundMapping = new Mapping();
            $foundMapping->mapping_id = $returnedRow['mapping_id'];
            $foundMapping->service_id = $returnedRow['service_id'];
            $foundMapping->room_code = $returnedRow['room_code'];
            $pdo->commit();

            return $foundMapping;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function findMappingByID($mapping_id): ?Mapping
    {
        return self::findMappingbyid_getAll($mapping_id);
    }

    private static function findAllMapping_getall(): ?array
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT * from mapping_room_service');
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            }

            $returnedRow = $query->fetchAll(PDO::FETCH_ASSOC);

            $listMapping = array();
            foreach ($returnedRow as $item) {

                $foundMapping = new Mapping();
                $foundMapping->room_code = $item['room_code'];
                $foundMapping->service_id = $item['service_id'];

                array_push($listMapping, $foundMapping);
            }

            $pdo->commit();


//            var_dump($listMapping);
            return $listMapping;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findAllMapping(): ?array
    {
        return self::findAllMapping_getall();
    }

    public function saveNew(): string
    {

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint


        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('INSERT into mapping_room_service (service_id, room_code) values (:service_id, :room_code)');
            $query->bindParam(':service_id', $this->service_id, PDO::PARAM_STR);
            $query->bindParam(':room_code', $this->room_code, PDO::PARAM_STR);

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

        if (is_null($this->mapping_id)) {
            throw new Exception('Cannot save edit without id');
        }

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('UPDATE mapping_room_service SET service_id=:service_id, room_code=:room_code WHERE mapping_id=:mapping_id');
            $query->bindParam(':mapping_id', $this->mapping_id, PDO::PARAM_STR);
            $query->bindParam(':service_id', $this->service_id, PDO::PARAM_STR);
            $query->bindParam(':room_code', $this->room_code, PDO::PARAM_STR);
            $query->execute();

            $newId = $pdo->lastInsertId();

            $pdo->commit();

            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function deleteMappingById($mapping_id) {
        if (!$mapping_id) {
            throw new Exception('No id given');
        }
        if (!self::findMappingByID($mapping_id)) {
            throw new Exception("No mapping with id ${mapping_id}");
        }

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('DELETE from mapping_room_service where mapping_id=:mapping_id');
            $query->bindParam(':mapping_id', $mapping_id, PDO::PARAM_STR);
            $query->execute();

            $deletedRowCount = $query->rowCount();

            $pdo->commit();

            if ($deletedRowCount == 0) {
                throw new Exception('No mapping was deleted');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

}