<?php

require_once('src/model/Book.php');

class BookService
{
    public static function getAllBook(): ?array
    {
        $Book = Book::findAllBook();

        return $Book;

    }

    public static function createBook(
        $room_code,
        $customer_id,
        $num_adult,
        $num_children,
        $check_in,
        $check_out

    )
    {
        if(!Room::findProductByRoomCode($room_code)) {
            throw new Exception('this room in book is not exist');
        }

        if (strlen($room_code) < 1) {
            throw new Exception ('room_code is invalid');
        }
        if (strlen($customer_id) < 1) {
            throw new Exception ('customer_id is invalid');
        }
        if (strlen($num_adult) < 1) {
            throw new Exception ('num_Adult is invalid');
        }
        if (strlen($num_children) < 1) {
            throw new Exception ('num_children is invalid');
        }
        if (strlen($check_in) < 1) {
            throw new Exception ('check in is invalid');
        }
        if (strlen($check_out) < 1) {
            throw new Exception ('check out is invalid');
        }

        $book = Book::newInstance(
            $room_code,
            $customer_id,
            $num_adult,
            $num_children,
            $check_in,
            $check_out
        );

        $newBookID = $book->saveNew();

        return $newBookID;
    }

    public static function editBook(
        $book_id,
        $room_code,
        $customer_id,
        $num_adult,
        $num_children,
        $check_in,
        $check_out
    ): ?Book
    {
        $book = Book::findBookByID($book_id);
        if (is_null($book)) {
            throw new Exception("No book with id {$book_id} found");
        }

        if ($room_code) {
            $book->setRoomCode($room_code);
        }
        if ($customer_id) {
            $book->setCustomerId($customer_id);
        }
        if ($num_adult) {
            $book->setNumAdult($num_adult);
        }
        if ($num_children) {
            $book->setNumChildren($num_children);
        }
        if ($check_in) {
            $book->setCheckIn($check_in);
        }
        if ($check_out) {
            $book->setCheckOut($check_out);
        }

        $book->saveEdit();

        $editedBook = Book::findBookByID($book_id);

        return $editedBook;
    }

    public static function deleteBookByID($book_id) {
        if (!is_numeric($book_id)) {
            throw new Exception('book ID is not a number');
        }
        if ((int)$book_id < 1) {
            throw new Exception('book ID is less than zero');
        }

        Book::deleteBookById($book_id);
    }
}