<?php
session_start();

//Connection
$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error) 
{
    die('Connection Failed : '. $conn->connect_error);
}

$loggedInUserEmail = $_SESSION['user_email'];

//Get user's balance from DB
$query = "SELECT bal FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $loggedInUserEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) 
{
    $user = $result->fetch_assoc();
    //Store the user's balance
    $userBalance = $user['bal'];
}

readfile("../../pages/deposit/Deposit.html");

$stmt->close();
?>
