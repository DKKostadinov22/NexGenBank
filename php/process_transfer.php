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

// Retrieve sender's balance
$senderQuery = "SELECT bal FROM users WHERE email = ?";
$senderStmt = $conn->prepare($senderQuery);
$senderStmt->bind_param('s', $loggedInUserEmail);
$senderStmt->execute();
$senderResult = $senderStmt->get_result();

if ($senderResult->num_rows == 1) 
{
    $sender = $senderResult->fetch_assoc();
    $senderBalance = $sender['bal']; // Get the sender's balance
}

$senderStmt->close();

// Check if the sender has sufficient balance
if ($senderBalance >= $amount) 
{
    $receiverQuery = "SELECT bal FROM users WHERE iban = ?";
    $receiverStmt = $conn->prepare($receiverQuery);
    $receiverStmt->bind_param('s', $iban);
    $receiverStmt->execute();
    $receiverResult = $receiverStmt->get_result();

    if ($receiverResult->num_rows == 1) 
    {
        $receiver = $receiverResult->fetch_assoc();
        $receiverBalance = $receiver['bal']; // Get the receiver's balance
    }

    $receiverStmt->close();

    // Update sender's balance after the transfer
    $updateSenderQuery = "UPDATE users SET bal = bal - ? WHERE email = ?";
    $updateSenderStmt = $conn->prepare($updateSenderQuery);
    $updateSenderStmt->bind_param('is', $amount, $loggedInUserEmail);
    $updateSenderStmt->execute();

    // Update receiver's balance after the transfer
    $updateReceiverQuery = "UPDATE users SET bal = bal + ? WHERE iban = ?";
    $updateReceiverStmt = $conn->prepare($updateReceiverQuery);
    $updateReceiverStmt->bind_param('is', $amount, $iban);
    $updateReceiverStmt->execute();

    // Redirect to a success page after transfer
    header("Location: ../php/transfer_success.php");
} 
else 
{
    // Insufficient balance, redirect to a failure page
    header("Location: ../php/transfer_failure.php");
}

$updateSenderStmt->close();
$updateReceiverStmt->close();
$conn->close();
?>
