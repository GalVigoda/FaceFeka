<?php
    require_once "functions.php";
    db_connect();
    $sql = "INSERT INTO posts (text, user_id, isPrivate) VALUES (?, ?, ?)";
    $isPrivate = $_POST['privatePost'] == 'true' ? 1 : 0;
    $statement = $conn->prepare ($sql);
    $statement->bind_param('sii', $_POST['content'], $_SESSION['user_id'], $isPrivate);
    if ($statement->execute()){
        redirect_to("/dashboard.php");
    }else {
        echo "Error!!! ".$conn->error;
    }
    $conn->close();
