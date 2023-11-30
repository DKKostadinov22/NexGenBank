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
    //Get the user's balance
    $userBalance = $user['bal'];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transfer</title>
</head>
<body>
    <form action="./process_transfer.php" method="post">
        <label for="iban">Enter IBAN:</label>
        <input type="text" id="iban" name="iban" required>
        <br>
        <label for="amount">Enter Amount:</label>
        <input type="number" id="amount" name="amount" min="1" max="<?php echo $userBalance; ?>" required>
        <br>
        <input type="submit" value="Transfer">
    </form>
</body>
</html>
