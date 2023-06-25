<?php
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header('Content-Type: application/json');

    $todo = $_POST;

    $todosStr = file_get_contents("data.json");
    $todos = json_decode($todosStr);

    $todos[] = $todo;

    $todosStr = json_encode($todos);

    file_put_contents("data.json", $todosStr);
    echo $todosStr;
