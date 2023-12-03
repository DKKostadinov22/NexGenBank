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

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add</title>
</head>
<body>
<form action="./process_add.php" method="post" id="paymentForm">
    <label for="cardNumber">Enter Card Number:</label>
    <input type="text" id="cardNumber" name="cardNumber" required>
    <br>
    <label for="expirationDate">Enter Expiration Date (MM/YY):</label>
    <input type="text" id="expirationDate" name="expirationDate" required>
    <br>
    <label for="fullName">Enter First and Last Name:</label>
    <input type="text" id="fullName" name="fullName" required>
    <br>
    <label for="cvv">Enter CVV:</label>
    <input type="text" id="cvv" name="cvv" required>
    <br>
    <label for="amount">Enter Amount:</label>
    <input type="number" id="amount" name="amount" min="1" max="1000" required>
    <br>
    <input type="submit" value="Add" id="submitButton" disabled>
</form>

<script>
    document.getElementById('paymentForm').addEventListener('input', function() 
    {
    var cardNumber = document.getElementById('cardNumber').value;
    var expirationDate = document.getElementById('expirationDate').value;
    var cvv = document.getElementById('cvv').value;
    var submitButton = document.getElementById('submitButton');

    // Check if the card number is 16 digits
    var isCardNumberValid = cardNumber.length === 16;

    // Check if the expiration date is in MM/YY format
    var expirationDatePattern = /^(0[1-9]|1[0-2])\/?([0-9]{2})$/;
    var isExpirationDateValid = expirationDate.match(expirationDatePattern);

    // Check if the CVV is 3 digits
    var isCVVValid = cvv.length === 3;

    // Enable/disable the submit button based on conditions
    if (isCardNumberValid && isExpirationDateValid && isCVVValid) 
    {
        submitButton.removeAttribute('disabled');
    } else 
    {
        submitButton.setAttribute('disabled', 'disabled');
    }
});
</script>




</body>
</html>
