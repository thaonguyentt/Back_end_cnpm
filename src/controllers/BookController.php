<?php

require_once ('src/services/BookService.php');

class BookController
{
    public static function getAllBook() {
        $book = BookService::getAllBook();

        echo json_encode($book);
    }

    public static function createNewBook() {

        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $room_code = $input['room_code'];
        $customer_id = $input['customer_id'];
        $num_adult = $input['num_adult'];
        $num_children = $input['num_children'];
        $check_in  =$input['check_in'];
        $check_out  =$input['check_out'];


        $newId = BookService::createBook(
            $room_code,
            $customer_id,
            $num_adult,
            $num_children,
            $check_in,
            $check_out
        );

        echo Book::findBookByID($newId)->serialize();

    }

    public static function editBook($book_id) {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $room_code = $input['room_code'];
        $customer_id = $input['customer_id'];
        $num_adult = $input['num_adult'];
        $num_children = $input['num_children'];
        $check_in = $input['check_in'];
        $check_out = $input['check_out'];


        $editedBook = BookService::editBook($book_id, $room_code, $customer_id, $num_adult, $num_children, $check_in, $check_out);
        echo $editedBook->serialize();
    }

    public static function deleteBook($book_id) {
        BookService::deleteBookByID($book_id);
    }
}