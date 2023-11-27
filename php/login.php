<?php
    //Connection
    $conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

    if ($conn->connect_error)
    {   
        die('Connection Failed : '. $conn->connect_error);
    }

    session_start();

    $username = $_POST['username'];
    $pass = $_POST['pass'];

?>