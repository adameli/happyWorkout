<?php

require "helpers.php";

$reqData = getRequestData();

$action = $_GET["action"] ?? "";

// begin to check the action query to decide what code to execute
if($action == "login"){

    $loginKeys = ["username", "password"];

    if(requestContainsAllKeys($reqData, $loginKeys) == false) {
        abort(400, "Bad Request (missing keys)");
    }

    $username = $reqData["username"];
    $password = $reqData["password"];
    $user = findItemByKey("users", "username", $username);

    if ($user == false) {
        abort(404, "User Not Found");
    }

    if ($user["password"] != $reqData["password"]) {
        abort(400, "Bad Request (invalid password)");
    }

    $token = ["token" => sha1($username . $password)];
    send(200, $token);

} elseif ($action == "register") {

    $userKeys = ["username", "password"];

    if(requestContainsAllKeys($reqData, $userKeys) == false) {
        abort(400, "Bad Request (missing keys)");
    }

    $username = $reqData["username"];
    $user = findItemByKey("users", "username", $username);

    if($user != false){
        abort(400, "Bad request (user already exists)");
    }

    $newUser = insertItemByType("users", $userKeys, $reqData);
    unset($newUser["password"]);
    send(201, $newUser);

} elseif($action == "all"){
    // all = the user wants all entities and the username

    $token = $reqData["token"];
    $newData = [];

    $user = getUserFromToken($token);

    if($user == false) abort(400, "Invalid token");

    $newData["username"] = $user["username"];

    $

    send(200, $newData);

}

