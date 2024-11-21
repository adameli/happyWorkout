<?php


function send($status = 200, $data = []){
    header("Content-Type: application/json");
    http_response_code($status);
    echo json_encode($data);
    exit();
}

function abort($status = 400, $message = "")
{
    send($status, ["error" => $message]);
}

function getRequestData()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        return $_GET;
    }

    if ($_SERVER["CONTENT_TYPE"] != "application/json") {
        abort(400, "Bad Request (invalid content type)");
    }

    $json = file_get_contents("php://input");
    return json_decode($json, true);
}

function getEntity ($type) {

    $entity = json_decode(file_get_contents("./entities/$type.json"), true);

    if($entity == false) abort(400, "The entity dosen't exists");
    
    return $entity;

}

function requestContainsAllKeys($data, $keys)
{
    foreach ($keys as $key) {
        if (isset($data[$key]) == false) {
            return false;
        }
    }

    return true;
}

function findItemByKey($type, $key, $value)
{
    $entity = getEntity($type);

    foreach ($entity as $item) {
        if ($item[$key] == $value) {
            return $item;
        }
    }

    return false;
}


function insertItemByType($type, $keys, $data)
{
    $entity = getEntity($type);

    $newItem = [];

    foreach ($keys as $key) {
        if ($key == "token") {
            continue;
        }
        $newItem[$key] = $data[$key];
    }

    $id = 0;

    foreach ($entity as $item) {
        if (isset($item["id"]) && $item["id"] > $id) {
            $id = $item["id"];
        }
    }

    $newItem["id"] = $id + 1;
    $entity[] = $newItem;
    $json = json_encode($entity, JSON_PRETTY_PRINT);
    file_put_contents("./entities/$type.json", $json);
    return $newItem;
}

function getUserFromToken($requestToken)
{
    $users = getEntity('users');
    

    foreach ($users as $user) {
        if (isset($user["username"], $user["password"])) {
            $name = $user["username"];
            $password = $user["password"];

            $userToken = sha1("$name$password");

            if ($requestToken == $userToken) {
                return $user;
            }
        }
    }

    return false;
}