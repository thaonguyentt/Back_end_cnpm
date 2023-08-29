<?php

require_once ('src/services/FeedbackService.php');

class FeedbackController
{
    public static function getAllFeedback() {
        $feedback = FeedbackService::getAllFeedback();

        echo json_encode($feedback);
    }

    public static function createNewFeedback() {

        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $name = $input['name'];
        $phone_number = $input['phone_number'];
        $email = $input['email'];
        $note = $input['note'];


        $newId = FeedbackService::createFeedback(
            $name,
            $phone_number,
            $email,
            $note
        );

        echo Feedback::findFeedbackByID($newId)->serialize();

    }

    public static function editFeedback($feedback_id) {
        $input = json_decode(file_get_contents('php://input'),true);
        if (is_null($input)) {
            throw new Exception('Invalid input json');
        }

        $name = $input['name'];
        $phone_number = $input['phone_number'];
        $email = $input['email'];
        $note = $input['note'];


        $editedFeedback = FeedbackService::editFeedback($feedback_id, $name, $phone_number, $email, $note);
        echo $editedFeedback->serialize();
    }

    public static function deleteFeedback($feedback_id) {
        FeedbackService::deleteFeedback($feedback_id);
    }
}