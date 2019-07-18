<?php
session_start();

function connect_to_db ()
{
    global $db_connection;
    $db_server = "localhost";
    $username = "root";
    $password = "";
    $database = "facefeka";

    $db_connection = new mysqli($db_server, $username, $password, $database);

    if ($db_connection->connect_error) {
        die("Error: " . $db_connection->connect_error);
    }
}


function redirect_to($url)
{
    header("Location: " . $url);
    exit();
}

function is_auth() {
    return isset($_SESSION['user_id']);
}

function check_auth() {
    if(!is_auth()) {
        redirect_to("/index.php?logged_in=false");
    }
}