<?php

require_once('src/utils/JwtUtils.php');
require_once('src/controllers/UserController.php');
require_once('src/controllers/AuthenticateController.php');
require_once('src/controllers/RoomController.php');
require_once('src/controllers/ServiceTypeController.php');
require_once('src/controllers/FeedbackController.php');
require_once('src/controllers/BookController.php');
require_once('src/controllers/MappingController.php');

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    $r->addRoute('GET', '/user/{id:\d+}', function ($id) {
        UserController::getUser($id);
    });

    $r->addRoute('POST', '/user', function () {
        UserController::createUser();
    });

    $r->addRoute('PUT', '/user/{id:\d+}', function ($id) {
        // allowUserWithId
        UserController::editUser($id);
    });

    $r->addRoute('DELETE', '/user/{id:\d+}', function ($id) {
        // allowUserWithId
        UserController::deleteUser($id);
    });

    $r->addRoute('POST', '/authenticate', function () {
        AuthenticateController::authenticateUser();
    });

    $r->addRoute('GET', '/authtest', function () {
        allowUser();
        echo "hehe";
    });


//    $r->addRoute('GET', '/room/{room_code:\d+}', function ($room_code) {
//        RoomController::getOneRoom($room_code);
//    });
    $r->addRoute('GET', '/room/allRoom', function () {
        RoomController::getAllRoom();
    });
    $r->addRoute('POST', '/room', function () {
        RoomController::createRoom();
    });

    //////////////
    $r->addRoute('POST', '/room/roomCondition', function () {
        RoomController::getAllRoomByDay();
    });
    /////////////
    $r->addRoute('PUT', '/room/{room_code:\d+}', function ($room_code) {
        RoomController::editRoom($room_code);
    });
    $r->addRoute('DELETE', '/room/{room_code:\d+}', function ($room_code) {
        // allowUserWithId
        RoomController::deleteRoom($room_code);
    });
    $r->addRoute('GET', '/room/{room_code:\d+}', function ($room_code) {
        RoomController::getOneRoom($room_code);
    });

    $r->addRoute('GET', '/room/{room_code:\d+}/service', function ($room_code) {
//        RoomController::getAllRoomService();
    });

    $r->addRoute('GET', '/room/{room_code:\d+}/service/', function ($room_code) {
//        RoomController::getAllRoomService();
    });

    $r->addRoute('POST', '/room/{room_code:\d+}/service', function ($room_code) {
//        RoomController::createRoomService();
    });

    $r->addRoute('PUT', '/room/{room_code:\d+}/service', function ($room_code) {
//        RoomController::editRoomService();
    });


    $r->addRoute('GET', '/serviceType/allServiceType', function () {
        ServiceTypeController::getAllServiceType();
    });
    $r->addRoute('POST', '/serviceType', function () {
        ServiceTypeController::createnewType();
    });
    $r->addRoute('PUT', '/serviceType/{type_id:\d+}', function ($type_id) {
       ServiceTypeController::editServiceType($type_id);
    });
    $r->addRoute('DELETE', '/serviceType/{type_id:\d+}', function ($type_id) {
        // allowUserWithId
        ServiceTypeController::deleteServiceType($type_id);
    });

    $r->addRoute('GET', '/feedback/allFeedback', function () {
        FeedbackController::getAllFeedback();
    });
    $r->addRoute('POST', '/feedback', function () {
        FeedbackController::createNewFeedback();
    });
    $r->addRoute('PUT', '/feedback/{feedback_id:\d+}', function ($feedback_id) {
        FeedbackController::editFeedback($feedback_id);
    });
    $r->addRoute('DELETE', '/feedback/{feedback_id:\d+}', function ($feedback_id) {
        // allowUserWithId
        FeedbackController::deleteFeedback($feedback_id);
    });


    // for admin
    $r->addRoute('GET', '/book/allBook', function () {
        BookController::getAllBook();
    });
    $r->addRoute('POST', '/booking', function () {
        BookController::createNewBook();
    });

    $r->addRoute('PUT', '/book/{book_id:\d+}', function ($book_id) {
        BookController::editBook($book_id);
    });
    $r->addRoute('DELETE', '/book/{book_id:\d+}', function ($book_id) {
        // allowUserWithId
        BookController::deleteBook($book_id);
    });

//    $r->addRoute('GET', '/test', function () {
//        ServiceTypeController::getAllTypeID();
//    });

    $r->addRoute('GET', '/mapping/allMapping', function () {
        MappingController::getAllMapping();
    });
    $r->addRoute('POST', '/mapping', function () {
        MappingController::createNewMapping();
    });

    $r->addRoute('PUT', '/mapping/{mapping_id:\d+}', function ($mapping_id) {
        MappingController::editMapping($mapping_id);
    });
    $r->addRoute('DELETE', '/mapping/{mapping_id:\d+}', function ($mapping_id) {
        // allowUserWithId
        MappingController::deleteMapping($mapping_id);
    });

});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "Invalid route";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        if (strcmp($_SERVER['REQUEST_METHOD'], 'OPTIONS') == 0) {
            http_response_code(200);
        } else {
            http_response_code(405);
            echo "Method not allowed";
        }
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        try {
            $handler(...$vars);
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 401:
                case 402:
                case 403:
                case 404:
                case 409:
                case 500:
                    http_response_code($e->getCode());
                    echo "{\"error\":\"{$e->getMessage()}\"}";
                    break;
                default:
                    http_response_code(500);
                    echo "{\"error\":\"{$e->getMessage()}\"}";
                    break;
            }

        }

        break;
}