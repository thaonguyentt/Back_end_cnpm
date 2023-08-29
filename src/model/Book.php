<?php

require_once('src/model/db.php');

class Book implements JsonSerializable
{
    private string $book_id;
    private string $room_code;
    private string $customer_id;
    private string $num_adult;
    private string $num_children;
    private string $check_in;
    private string $check_out;
    private string $num_night;
    private string $total_price;

    /**
     * @param string $total_price
     */
    public function setTotalPrice(string $total_price): void
    {
        $this->total_price = $total_price;
    }

    /**
     * @param string $num_night
     */
    public function setNumNight(string $num_night): void
    {
        $this->num_night = $num_night;
    }

    /**
     * @param string $check_out
     */
    public function setCheckOut(string $check_out): void
    {
        $this->check_out = $check_out;
    }


    /**
     * @param string $check_in
     */
    public function setCheckIn(string $check_in): void
    {
        $this->check_in = $check_in;
    }


    /**
     * @param string $num_children
     */
    public function setNumChildren(string $num_children): void
    {
        $this->num_children = $num_children;
    }

    /**
     * @param string $room_code
     */
    public function setRoomCode(string $room_code): void
    {
        $this->room_code = $room_code;
    }

    /**
     * @param string $customer_id
     */
    public function setCustomerId(string $customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @param string $num_adult
     */
    public function setNumAdult(string $num_adult): void
    {
        $this->num_adult = $num_adult;
    }

    /**
     * @param string $book_id
     */
    public function setBookId(string $book_id): void
    {
        $this->book_id = $book_id;
    }


    public static function newInstance(string $room_code, string $customer_id, string $num_adult, string $num_children, string $check_in, string $check_out)
    {
        $book = new Book();
        $book->room_code = $room_code;
        $book->customer_id = $customer_id;
        $book->num_adult= $num_adult;
        $book->num_children= $num_children;
        $book->check_in= $check_in;
        $book->check_out= $check_out;

        return $book;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function serialize(): string
    {
        return json_encode($this);
    }


    private static function findBookbyid_getAll(string $book_id): ?Book
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT book_id, room_code, customer_id, num_adult, num_children, check_in, check_out, num_night from book where book_id = :book_id');
            $query->bindParam(':book_id', $book_id, PDO::PARAM_STR);
            $query->execute();

            // get row count
            $rowCount = $query->rowCount();

            if ($rowCount == 0) {
                return null;
            } else if ($rowCount > 1) {
                throw new Exception('More than 1 book found.');
            }

            $returnedRow = $query->fetch(PDO::FETCH_ASSOC);

            $foundBook = new Book();
            $foundBook->book_id = $returnedRow['book_id'];
            $foundBook->room_code = $returnedRow['room_code'];
            $foundBook->customer_id = $returnedRow['customer_id'];
            $foundBook->num_adult = $returnedRow['num_adult'];
            $foundBook->num_children = $returnedRow['num_children'];
            $foundBook->check_in = $returnedRow['check_in'];
            $foundBook->check_out = $returnedRow['check_out'];
            $foundBook->num_night= $returnedRow['num_night'];
            $pdo->commit();

            return $foundBook;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function findBookByID($book_id): ?Book
    {
        return self::findBookbyid_getAll($book_id);
    }



    private static function findAllBook_getall(): array
    {
        $pdo = DB::connectReadDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('SELECT * from book');
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $listBook = array();
            foreach ($result as $item) {

                $foundBook = new Book();
                $foundBook->book_id = $item['book_id'];
                $foundBook->room_code = $item['room_code'];
                $foundBook->customer_id = $item['customer_id'];
                $foundBook->num_adult = $item['num_adult'];
                $foundBook->num_children = $item['num_children'];
                $foundBook->check_in = $item['check_in'];
                $foundBook->check_out = $item['check_out'];
                $foundBook->num_night= $item['num_night'];

                array_push($listBook, $foundBook);
            }

            $pdo->commit();


//            var_dump($listBook);
            return $listBook;

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function findAllBook(): ?array
    {
        return self::findAllBook_getall();
    }

    public function saveNew(): string
    {

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint


        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('INSERT into book (room_code, customer_id, num_adult, num_children, check_in, check_out) values (:room_code, :customer_id, :num_adult, :num_children, :check_in, :check_out)');
            $query->bindParam(':room_code', $this->room_code, PDO::PARAM_STR);
            $query->bindParam(':customer_id', $this->customer_id, PDO::PARAM_STR);
            $query->bindParam(':num_adult', $this->num_adult, PDO::PARAM_STR);
            $query->bindParam(':num_children', $this->num_children, PDO::PARAM_STR);
            $query->bindParam(':check_in', $this->check_in, PDO::PARAM_STR);
            $query->bindParam(':check_out', $this->check_out, PDO::PARAM_STR);

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

        if (is_null($this->book_id)) {
            throw new Exception('Cannot save edit without id');
        }

        // Duplicate check logic should live in db schema
        // using UNIQUE constraint

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('UPDATE book SET room_code=:room_code, customer_id=:customer_id, num_adult=:num_adult, num_children=:num_children, check_in=:check_in, check_out=:check_out WHERE book_id=:book_id');
            $query->bindParam(':book_id', $this->book_id, PDO::PARAM_STR);
            $query->bindParam(':room_code', $this->room_code, PDO::PARAM_STR);
            $query->bindParam(':customer_id', $this->customer_id, PDO::PARAM_STR);
            $query->bindParam(':num_adult', $this->num_adult, PDO::PARAM_STR);
            $query->bindParam(':num_children', $this->num_children, PDO::PARAM_STR);
            $query->bindParam(':check_in', $this->check_in, PDO::PARAM_STR);
            $query->bindParam(':check_out', $this->check_out, PDO::PARAM_STR);
            $query->execute();

            $newId = $pdo->lastInsertId();

            $pdo->commit();

            return $newId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }

    public static function deleteBookById($book_id) {
        if (!$book_id) {
            throw new Exception('No id given');
        }
        if (!self::findBookByID($book_id)) {
            throw new Exception("No book with id ${book_id}");
        }

        $pdo = DB::connectWriteDB();

        try {
            $pdo->beginTransaction();

            $query = $pdo->prepare('DELETE from book where book_id=:book_id');
            $query->bindParam(':book_id', $book_id, PDO::PARAM_STR);
            $query->execute();

            $deletedRowCount = $query->rowCount();

            $pdo->commit();

            if ($deletedRowCount == 0) {
                throw new Exception('No book was deleted');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }

    }


}