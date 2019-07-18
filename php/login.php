<?php
  require_once "functions.php";

  connect_to_db();

  $sql = "SELECT id, username, password FROM users WHERE username = ?";
  $statement = $db_connection->prepare($sql);
  $statement->bind_param('s', $_POST['username']);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $username, $password);
  $statement->fetch();

  if ($statement->execute()) {
    if(password_verify($_POST['password'], $password)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['user_username'] = $username;
      redirect_to("/dashboard.php");
    } else {
      redirect_to("/index.php?login_error=true");
    }
  } else {
    echo "Error: " . $db_connection->error;
  }

  $db_connection->close();