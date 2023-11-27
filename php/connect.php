<?php
    //Connection
    $conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_repeat = $_POST['pass_repeat'];

    if ($conn->connect_error)
    {   
        die('Connection Failed : '. $conn->connect_error);
    }

    $check = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username'");
    $check2 = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
    $check3 = mysqli_query($conn, "SELECT * FROM `users` WHERE phone_number = '$phone_number'");

    if(mysqli_num_rows($check) > 0)
    {
        echo "Username already in use!";
    }
    else if(mysqli_num_rows($check2) > 0)
    {
        echo "Email already in use!";
    }
    else if(mysqli_num_rows($check3) > 0)
    {
        echo "Phone number already in use!";
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, gender, phone_number, username, email, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisss", $first_name, $last_name, $gender, $phone_number, $username, $email, $pass);
        $stmt->execute();
        echo "Registration Successfully";
        $stmt->close();
        $conn->close();
    }
?>