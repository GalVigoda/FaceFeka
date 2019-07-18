<?php
    require_once "functions.php";
    connect_to_db();
    $sql = "INSERT INTO posts (text, user_id) VALUES (?, 2)";
    $statement = $db_connection->prepare ($sql);
    $statement->bind_param('s', $_POST['content']);
    if ($statement->execute()){
        redirect_to("/dashboard.php");
    }else {
        echo "Error!!! ".$db_connection->error;
    }
