<?php

session_start();

$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error) 
{
    die('Connection Failed : '. $conn->connect_error);
}

$loggedInUserEmail = $_SESSION['user_email'];
$iban = $_POST['iban'];
$amount = $_POST['amount'];

//Get sender's balance from DB
$senderQuery = "SELECT bal FROM users WHERE email = ?";
$senderStmt = $conn->prepare($senderQuery);
$senderStmt->bind_param('s', $loggedInUserEmail);
$senderStmt->execute();
$senderResult = $senderStmt->get_result();

if ($senderResult->num_rows == 1) 
{
    $sender = $senderResult->fetch_assoc();
    $senderBalance = $sender['bal']; //Store the sender's balance
}

$senderStmt->close(); //Close the sender statement

//Check if the sender has sufficient balance
if ($senderBalance >= $amount) 
{

    // Check if the receiver's IBAN exists in the database
    $checkReceiverQuery = "SELECT bal FROM users WHERE iban = ?";
    $checkReceiverStmt = $conn->prepare($checkReceiverQuery);
    $checkReceiverStmt->bind_param('s', $iban);
    $checkReceiverStmt->execute();
    $checkReceiverResult = $checkReceiverStmt->get_result();

    if ($checkReceiverResult->num_rows == 1) 
    {
        //If receiver's IBAN exists, proceed with the transfer

        $receiver = $checkReceiverResult->fetch_assoc();

        //Update sender's balance after the transfer
        $updateSenderQuery = "UPDATE users SET bal = bal - ? WHERE email = ?";
        $updateSenderStmt = $conn->prepare($updateSenderQuery);
        $updateSenderStmt->bind_param('is', $amount, $loggedInUserEmail);
        $updateSenderStmt->execute();

        //Update receiver's balance after the transfer
        $updateReceiverQuery = "UPDATE users SET bal = bal + ? WHERE iban = ?";
        $updateReceiverStmt = $conn->prepare($updateReceiverQuery);
        $updateReceiverStmt->bind_param('is', $amount, $iban);
        $updateReceiverStmt->execute();

        //Retrieve updated sender's balance
        $updatedSenderQuery = "SELECT bal FROM users WHERE email = ?";
        $updatedSenderStmt = $conn->prepare($updatedSenderQuery);
        $updatedSenderStmt->bind_param('s', $loggedInUserEmail);
        $updatedSenderStmt->execute();
        $updatedSenderResult = $updatedSenderStmt->get_result();

        if ($updatedSenderResult->num_rows == 1) 
        {
            $updatedSender = $updatedSenderResult->fetch_assoc();
            $_SESSION['user_bal'] = $updatedSender['bal']; //Update session variable with the updated balance
        }

        $updatedSenderStmt->close(); //Close the statement

        //Redirect to a success page after transfer
        readfile("../pages/transfer/transfer_success.html");
    }
    else 
    {
        //If receiver's IBAN doesn't exist in the DB, redirect to error page
        readfile("../pages/transfer/transfer_fail.html");
    }

    $checkReceiverStmt->close(); //Close the check receiver statement
}
else 
{
    readfile("../pages/transfer/transfer_no_bal.html");
}

$updateSenderStmt->close(); //Close the update sender statement
$updateReceiverStmt->close(); //Close the update receiver statement
$conn->close();
?>
