<?php
//Connection
$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error)
{
    die('Connection Failed : '. $conn->connect_error);
}

session_start();

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    //Gets user credentials from DB
    $query = "SELECT * FROM users WHERE email = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) 
    {
        //Redirect to a page where you are logged in and site functions
        header("Location: ../html/Logged.html");
    }
     else 
    {
        echo "Invalid email or password";
    }

    $stmt->close();
?>
