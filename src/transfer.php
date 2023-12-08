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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/Transfer.css">
    <title>NGB</title>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="../images/logo_green.png" alt="Logo" width="131" height="109" class="d-inline-block align-text-center">
            NextGenBank
          </a>
          <br>   
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../pages/Exchange.html">Exchange</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active"  aria-current="page"  href="#">Transfer</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


<!--Transfer Card-->
<div class="card text-center" id="card-body">
    <div class="card-body">
        <div class="container">
        <br>
        <!--Header-->
        <h1>Transfer</h1>
        <hr><br><br><br>

        <form action="../src/process_transfer.php" method="post">
        <!--IBAN-->  
        <input placeholder="IBAN number" type="text" id="iban" name="iban" required>
        <br><br>

        <!--Add Amount input-->
        <input placeholder="💳 Add amount" type="number" id="amount" name="amount" min="1" max="<?php echo $userBalance; ?>" required>
        <br><br><br><br><hr>

        <!--Submit button-->
        <input class="submitbtn" type="submit" value="Submit">
        </form>

        </div>
    </div>
</div>
</div>

<!--Gap-->
<div class="gap"></div>

<!--Footer-->
<footer>
  <div class="footer">
    <div class="logo_and_text">
      <img class="logo_white" src="../images/logo_white.png" alt="Logo_white">
      <div class="text_block">
        <h4 class="footer_logo_text">NexGenBank</h4>
      </div>
      <img src="../images/Line_30liniq.png" alt="white_line">
      <a target="_blank" href="https://www.codingburgas.bg/"><img class="vscpi_logo" src="../images/vscpi_logo.png" alt="Vscpi_logo"></a>
      <h4 class="part_of">part of</h4>
      <h4 class="footer_logo_text2">VSCPI</h4>
    </div>

    <h4 class="abt_us">Contributors</h4>
    <br>
    <h6 class="abt_us2">Scrum: DKKostadinov22</h6>
    <h6 class="abt_us2">Back-end: BRMilev22</h6>
    <h6 class="abt_us2">Front-end: DPDimitrakov22</h6>
    <h6 class="abt_us2">Designer: PRPetkov22</h6>

    <div class="contact">
      <h4 class="contact_text">Contact us</h4>
      <a target="_blank" href="https://www.instagram.com/_nexgenbank_/"><img class="ig_logo" src="../images/ig_logo.png" alt="IG Logo"></a>
      <a target="_blank" href="https://github.com/DKKostadinov22/NexGenBank"><img class="gh_logo" src="../images/gh_logo.png" alt="GH Logo"></a>
    </div>

  </div>
</footer>

</body>
</html>