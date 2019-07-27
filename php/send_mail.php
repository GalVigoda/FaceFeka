<?php
    require_once "functions.php";
    db_connect();
    $sql = "INSERT INTO friend_requests (user_id, friend_id) VALUES (?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('ii', $_SESSION['user_id'], $_GET['uid']);
    if ($statement->execute()) {
        redirect_to("/dashboard.php?request_sent=true");
    } else {
        echo "Error: " . $conn->error;
    }

  $sql = "SELECT Email, id, username FROM users";
  $statement = $conn->prepare($sql);
  $statement->bind_param('Email', $_POST['Email']);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $username, $password);
  $statement->fetch();