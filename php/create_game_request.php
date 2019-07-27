
<?php
    require_once "functions.php";
    db_connect();
    $redirect_url = "http://localHost:5000/invite?firstName=".$_POST['firstName']."&color=".$_POST['color']."&roomNumber=".$_POST['roomNumber'];
    $userSql = "SELECT username FROM users WHERE users.id = {$_POST['to_user']}";
    $result = $conn->query($userSql);
    if ($result->num_rows > 0)
    {
        if ($user = $result->fetch_assoc()){
            $sql = "INSERT INTO game_requests (from_user, to_user, url) VALUES (?, ?, ?)";
            $statement = $conn->prepare ($sql);
            $url = "http://localHost:5000/invite?firstName=".$user['username']."&color=green&roomNumber=".$_POST['roomNumber'];
            $statement->bind_param('iis', $_SESSION['user_id'], $_POST['to_user'], $url);
            if (!$statement->execute()){
                echo "Error!!! ".$conn->error;
            }
        }
    }
    redirect_to($redirect_url);
    $conn->close();
