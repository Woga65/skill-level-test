<?php

require 'cambridge.class.php';

switch($_SERVER['REQUEST_METHOD']) {
    case("OPTIONS"):                                        //Allow preflighting to take place.
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: content-type");
        exit;

    case("POST"):                                           //Perform Cambridge
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        if ($params && property_exists($params, 'message')) {
            $cambridge = new Cambridge($params->message);
            $text = $cambridge->scramble();
            $jsonResult = [
                "err" => "",
                "ok" => true,
                "data" => [ "message" => [$text], ],
            ];
            echo json_encode($jsonResult);
        } else {
            echo '{ "err": "empty", "ok": false, "fields": ["message"] }';
        }
        exit;

    default:                                                //Reject any non POST or OPTIONS requests.
        header("Allow: POST", true, 405);
        exit;
}
