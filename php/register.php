<?php
    //Connection
    $conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

    if ($conn->connect_error)
    {   
        die('Connection Failed : '. $conn->connect_error);
    }

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_repeat = $_POST['pass_repeat'];

    //Checks to see if username, email or phone number already exist in the db
    $check = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username'");
    $check2 = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
    $check3 = mysqli_query($conn, "SELECT * FROM `users` WHERE phone_number = '$phone_number'");

    //Initializes every part that should be included in the password
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);
    $specialChars = preg_match('@[^\w]@', $pass);

    //Initializes the phone number pattern
    $pattern = "/^08[789][0-9]{7}$/";

    //DB formatting, and filtering
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        echo $email . ' is NOT a valid email address.';
    }
    else if (!preg_match($pattern, $phone_number)) 
    {
        echo $phone_number . ' is NOT a valid phone number.';
    }
    else if($pass != $pass_repeat)
    {
        echo "Passwords don't match";
    }
    else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) 
    {
        echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
    }
    else if(mysqli_num_rows($check) > 0)
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
        $stmt->bind_param("sssssss", $first_name, $last_name, $gender, $phone_number, $username, $email, $pass);
        $stmt->execute();
        echo "Registration Successfully";
        $stmt->close();
        $conn->close();
    }
?>