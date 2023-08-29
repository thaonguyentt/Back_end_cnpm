<?php

require_once('src/model/Feedback.php');

class FeedbackService
{


    public static function getAllFeedback(): ?array
    {
        $feedback = Feedback::findAllFeedback();

        return $feedback;

    }

    public static function createFeedback(
        $name,
        $phone_number,
        $email,
        $note

    )
    {
//        if(Room::findProductByRoomCode($room_code)) {
//            throw new Exception('this feedback is already existed');
//        }

        if (strlen($name) < 1) {
            throw new Exception ('name is invalid');
        }
        if (strlen($phone_number) < 6) {
            throw new Exception ('phone number is invalid');
        }
        if (strlen($email) < 1
            || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception ('email is invalid');
        }
        if (strlen($note) < 6) {
            throw new Exception ('note is invalid');
        }

        $feedback = Feedback::newInstance(
            $name,
            $phone_number,
            $email,
            $note
        );

        $newFeedbackID = $feedback->saveNew();

        return $newFeedbackID;
    }

    public static function editFeedback(
        $feedback_id,
        $name,
        $phone_number,
        $email,
        $note
    ): ?Feedback
    {
        $feedback = Feedback::findFeedbackByID($feedback_id);
        if (is_null($feedback)) {
            throw new Exception("No feedback with id {$feedback_id} found");
        }

        if ($name) {
            $feedback->setName($name);
        }
        if ($phone_number) {
            $feedback->setPhoneNumber($phone_number);
        }
        if ($email) {
            $feedback->setEmail($email);
        }
        if ($note) {
            $feedback->setNote($note);
        }

        $feedback->saveEdit();

        $editedFeedback = Feedback::findFeedbackByID($feedback_id);

        return $editedFeedback;
    }

    public static function deleteFeedback($feedback_id) {
        if (!is_numeric($feedback_id)) {
            throw new Exception('feedback ID is not a number');
        }
        if ((int)$feedback_id < 1) {
            throw new Exception('feedback ID is less than zero');
        }

        Feedback::deleteFeedbackById($feedback_id);
    }
}