<?php
    require_once "functions.php";
    connect_to_db();
    $sql = "DELETE FROM posts WHERE id = ?";
    $statement = $db_connection->prepare($sql);
    $statement->bind_param('i', $_GET['id']);
    if ($statement->execute()) {
        redirect_to('/dashboard.php');
    } else {
        echo "Error!!! " . $db_connection->error;
    }
    $db_connection->close();
