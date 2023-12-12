<?php
session_start();

//Connection
$conn = new mysqli('sql11.freemysqlhosting.net', 'sql11669919', 'kgzx5LEnIr', 'sql11669919');

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
