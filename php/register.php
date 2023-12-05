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

    // Function to generate a random IBAN
    function generateRandomIBAN() 
    {
    $countryCode = "BG"; // Change to appropriate country code
    $randomNumbers = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    $iban = $countryCode . $randomNumbers;
    return $iban;
    }

    $iban = generateRandomIBAN(); // Generate IBAN
    $bal = 0;

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
      readfile("../html/register_checks/email_validate.html");
    }
    else if (!preg_match($pattern, $phone_number)) 
    {
      readfile("../html/register_checks/phone_validate.html");
    }
    else if($pass != $pass_repeat)
    {
      readfile("../html/register_checks/pass_repeat_check.html");
    }
    else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) 
    {
      readfile("../html/register_checks/pass_check.html");
    }
    else if(mysqli_num_rows($check) > 0)
    {
      readfile("../html/register_checks/username_exist.html");
    }
    else if(mysqli_num_rows($check2) > 0)
    {
      readfile("../html/register_checks/email_exist.html");
    }
    else if(mysqli_num_rows($check3) > 0)
    {
      readfile("../html/register_checks/phone_exist.html");
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, gender, phone_number, username, email, pass, iban, bal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssi", $first_name, $last_name, $gender, $phone_number, $username, $email, $pass, $iban, $bal);
        $stmt->execute();
        readfile("../html/register_checks/register_success.html");
        $stmt->close();
        $conn->close();
    }
?>