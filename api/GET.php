<?php

require "helpers.php";

$reqData = getRequestData();

$entity = getEntity('users');

print_r($entity);

$key = "username";
$value = "Adam";

// foreach ($entity as $item) {
//     if ($item[$key] == $value) {
//         print_r($item);
//     }
// }