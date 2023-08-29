<?php

require_once('src/model/db.php');

class Feedback implements JsonSerializable
{
    private string $feedback_id;
    private string $name;
    private string $phone_number;
    private string $email;
    private string $note;

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote(string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
    public function getFeedbackId(): string
    {
        return $this->feedback_id;
    }

    /**
     * @param string $feedback_id
     */
    public function setFeedbackId(string $feedback_id): void
    {
        $this->feedback_id = $feedback_id;
    }




    public static function newInstance(string $name, string $phone_number, string $email, string $note)
    {
        $feedback = new Feedback();
        $feedback->name = $name;
        $feedback->phone_number = $phone_number;
        $feedback->email= $email;
        $feedback->note= $note;

        return $feedback;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function serialize(): string
    {
        return json_encode($this);
    }

    private static function findFeedbackbyid_getAll(string $feedback_id): ?Feedback
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT feedback_id, name, phone_number, email, note from feedback where feedback_id = :feedback_id');
            $query->bindParam(':feedback_id', $feedback_id, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 feedback found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundFeeback = new Feedback();
            $foundFeeback->feedback_id = $returnedRow['feedback_id'];
            $foundFeeback->name = $returnedRow['name'];
            $foundFeeback->phone_number = $returnedRow['phone_number'];
            $foundFeeback->email = $returnedRow['email'];
            $foundFeeback->note = $returnedRow['note'];
            $pdo->commit();

            return $foundFeeback;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function findFeedbackByID($feeback_id): ?Feedback
    {
        return self::findFeedbackbyid_getAll($feeback_id);
    }



    private static function findAllFeedback_getall(): array
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT * from feedback');
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $listFeedback = array();
            foreach ($result as $item) {

                $foundFeeback = new Feedback();
                $foundFeeback->feedback_id = $item['feedback_id'];
                $foundFeeback->name = $item['name'];
                $foundFeeback->phone_number = $item['phone_number'];
                $foundFeeback->email = $item['email'];
                $foundFeeback->note = $item['note'];

                array_push($listFeedback, $foundFeeback);
            }

            $pdo->commit();


//            var_dump($listFeedback);
            return $listFeedback;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findAllFeedback(): ?array
    {
        return self::findAllFeedback_getall();
    }

    public function saveNew(): string
    {

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint


        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('INSERT into feedback (name, phone_number, email, note) values (:name, :phone_number, :email, :note)');
            $query->bindParam(':name', $this->name, PDO::PARAM_STR);
            $query->bindParam(':phone_number', $this->phone_number, PDO::PARAM_STR);
            $query->bindParam(':email', $this->email, PDO::PARAM_STR);
            $query->bindParam(':note', $this->note, PDO::PARAM_STR);

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

        if (is_null($this->feedback_id)) {
            throw new Exception('Cannot save edit without id');
        }

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('UPDATE feedback SET name=:name, phone_number=:phone_number, email=:email, note=:note WHERE feedback_id=:feedback_id');
            $query->bindParam(':feedback_id', $this->feedback_id, PDO::PARAM_STR);
            $query->bindParam(':name', $this->name, PDO::PARAM_STR);
            $query->bindParam(':phone_number', $this->phone_number, PDO::PARAM_STR);
            $query->bindParam(':email', $this->email, PDO::PARAM_STR);
            $query->bindParam(':note', $this->note, PDO::PARAM_STR);
            $query->execute();

            $newId = $pdo->lastInsertId();

            $pdo->commit();

            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function deleteFeedbackById($feedback_id) {
        if (!$feedback_id) {
            throw new Exception('No id given');
        }
        if (!self::findFeedbackByID($feedback_id)) {
            throw new Exception("No feedback with id ${feedback_id}");
        }

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('DELETE from feedback where feedback_id=:feedback_id');
            $query->bindParam(':feedback_id', $feedback_id, PDO::PARAM_STR);
            $query->execute();

            $deletedRowCount = $query->rowCount();

            $pdo->commit();

            if ($deletedRowCount == 0) {
                throw new Exception('No feedback was deleted');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }
}