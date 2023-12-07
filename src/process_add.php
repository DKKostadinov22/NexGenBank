<?php

session_start();

$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error) 
{
    die('Connection Failed : '. $conn->connect_error);
}

$loggedInUserEmail = $_SESSION['user_email'];
$amount = $_POST['amount'];

//Get user's balance from DB
$addQuery = "SELECT bal FROM users WHERE email = ?";
$addStmt = $conn->prepare($addQuery);
$addStmt->bind_param('s', $loggedInUserEmail);
$addStmt->execute();
$addResult = $addStmt->get_result();

if ($addResult->num_rows == 1) 
{
    $add = $addResult->fetch_assoc();
    $addBalance = $add['bal']; //Store the balance
}

    $addStmt->close(); //Close the add statement

    //Update balance after the add
    $updateaddQuery = "UPDATE users SET bal = bal + ? WHERE email = ?";
    $updateaddStmt = $conn->prepare($updateaddQuery);
    $updateaddStmt->bind_param('is', $amount, $loggedInUserEmail);
    $updateaddStmt->execute();


    //Retrieve updated balance, so it can update the variable in Logged_verified.php 
    $updatedaddQuery = "SELECT bal FROM users WHERE email = ?";
    $updatedaddStmt = $conn->prepare($updatedaddQuery);
    $updatedaddStmt->bind_param('s', $loggedInUserEmail);
    $updatedaddStmt->execute();
    $updatedaddResult = $updatedaddStmt->get_result();

    if ($updatedaddResult->num_rows == 1) 
    {
        $updatedadd = $updatedaddResult->fetch_assoc();
        $_SESSION['user_bal'] = $updatedadd['bal']; //Update session variable with the updated balance
    }

    ////////////////////////////////////////////////////////////

    $updatedaddStmt->close();//Close the statement

    // Redirect to a success page after money add
    header("Location: ../pages/add_success.html");

$updateaddStmt->close();
$updateReceiverStmt->close();
$conn->close();
?>
