<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" href="../css/Logged.css">
    <title>NGB</title>
</head>
<body>
    <script src="../JS/Verification.js" defer></script>


<!--Navbar-->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="../images/logo_green.png" alt="Logo" width="131" height="109" class="d-inline-block align-text-center">
        NexGenBank
      </a>
      <br>   
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./html/About Us.html">About Us</a>
          </li>
          <li class="nav-item" id="nav-item-icon">
            <img src="../images/pngegg.png">
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!--Eclipses-->
<div class="ellipse_group">
    <div class="elliplse_1"><p class="ellipse-text">“NO physical branches!”</p></div>
    <div class="elliplse_2"><p class="ellipse-text">“NGB”</p></div>
    <div class="elliplse_3"><p class="ellipse-text" id="Ellipse3-text">“Еasy and secure banking”</p></div>
</div>


<!--Login Information-->
<div class="card text-center" id="card-body">
    <div class="card-body">
            <div class="container">
                <!--Card Header-->
                <hr>
                <h1 class="card-h1">Logged in as:</h1>
                <br>
                <!--Account name-->
                <div class="container" id="account-name-container">
                    <p>
                        <?php

                        session_start();

                        $email = $_SESSION['user_email'];

                        echo $email;
                        echo
                        '
                        <br>';
                        ?>
                    </p>
                </div>
                <br>

                <!--Log out button-->
                <button class="log-outbtn"><a href="../index.html">Log out</a></button>
                <br><hr>

                <!--Card text for upload-->
                <h1 class="card-h1-2">Your account is not verified!</h1>
                <p class="">To unlock the full features, please submit a photo of your ID card, so we can verify your account!</p>
                <img class="upload-cloud-img" src="../images/upload_cloud.png"><br><br>

                <!--Upload Form-->
                <form action="./verification.php" enctype="multipart/form-data">

                <label for="file-upload" class="custom-file-upload">
                    <input id="file-upload" type="file" name="uploadedFile" onchange="enableUpload()" accept="image/*"> Browse files...
                </label><br><br>

                <!--Upload Button-->
                <div class="spinner-border text-success" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>

                </form>
            </div>
        </div>
    </div>


<div class="quote">
    <div class="quote-text">
    <h1>"Banking on a sustainable future. Together, let's invest in a greener tomorrow."</h1>
</div>

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

</div>
</body>
</html>

<?php
$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}


$verified = 1;

$email = $_SESSION['user_email'];
$stmt = $conn->prepare("UPDATE users SET verified = ? WHERE email = ?");
$stmt->bind_param("is", $verified, $email);
$stmt->execute();

$stmt->close();
$conn->close();
?>




</body>
</html>

