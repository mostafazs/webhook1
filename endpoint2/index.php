<?php

$data = json_decode(file_get_contents("php://input"), true);

file_put_contents("message_recieved.txt", print_r($data, true));
