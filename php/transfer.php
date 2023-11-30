<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../html/login.html"); // Redirect to login page if not logged in
    exit();
}

$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error) {
    die('Connection Failed : '. $conn->connect_error);
}

$loggedInUserEmail = $_SESSION['user_email'];

// Retrieve user's balance
$query = "SELECT bal FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $loggedInUserEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $userBalance = $user['bal']; // Get the user's balance
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your HTML head content -->
    <title>Transfer</title>
</head>
<body>
    <!-- Your existing HTML content -->
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


<?php
    // Handle the balance update after transfer in process_transfer.php

    // Check if transfer is successful and update the session variable
    if (isset($_SESSION['transfer_successful']) && $_SESSION['transfer_successful']) {
        // Retrieve the updated balance after transfer from the database
        $query = "SELECT bal FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $loggedInUserEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_bal'] = $user['bal']; // Update the session variable with the new balance
        }

        $stmt->close();
        unset($_SESSION['transfer_successful']); // Unset the session variable for transfer success
    }
    ?>