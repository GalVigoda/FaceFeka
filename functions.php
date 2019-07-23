<?php
    function db_connect() {
        global $conn; // db connection variable
        $db_server = "localhost";
        $username = "root";
        $password = "";
        $db_name = "faceclone";
        // create a connection
        $conn = new mysqli($db_server, $username, $password, $db_name);
        // check connection for errors
        if ($conn->connect_error) {
            die("Error: " . $conn->connect_error);
        }
        // uncomment the line below to confirm a connection is established
         echo '<h1 style="color: green;">Connected to DB!</h1>';
        // your can clear these comments afterwards
    }
    