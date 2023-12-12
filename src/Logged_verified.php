<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" href="../styles/Logged-Verified.css">
    <link rel="icon" href="../images/logo_white.png">
    <title>NexGenBank</title>
</head>
<body>
    <script src="../script/Logged_verified.js" defer></script>


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
            <a class="nav-link" href="../pages/About-Us.html">About Us</a>
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
  <div class="elliplse_1">
    <p class="ellipse-text ellipse-1-text">“NO physical branches!”</p>
  </div>
  <div class="elliplse_2">
    <p class="ellipse-text ellipse-2-text">“NGB”</p>
    <p class="ellipse-subscript">Made by professionals</p>
  </div>
  <div class="elliplse_3">
    <p class="ellipse-text ellipse-3-text">“Еasy and secure banking”</p>
  </div>
</div>


<!--Login Information-->
<div class="card text-center" id="card-body">
    <div class="card-body">
            <div class="container">
                
              <!--Account name-->
                <hr>
                <h1 class="card-h1">Logged in as:</h1>
                <div class="container" id="account-name-container">
                    <p>
                        <?php

                        session_start();

                        $username = $_SESSION['user_username'];
                        $iban = $_SESSION['user_iban'];
                        $bal = $_SESSION['user_bal'];

                        echo $username;
                        echo
                        '
                        <br>';
                        ?>
                    </p>
                </div>
                <br>
                
              <!--IBAN-->
                <h1 class="card-h1">IBAN:</h1>
                <div class="container" id="account-name-container">
                    <p>
                      <?php
                      echo $iban;
                      echo
                      '
                      <br>';
                      ?>
                    </p>
                </div>
                <br>

                <!--Balance-->
                <h1 class="card-h1">Balance:</h1>
                <div class="container" id="account-name-container">
                    <p>
                      <?php
                      echo $bal;
                      echo
                      '
                      <br>';
                      ?>
                    </p>
                </div>
                <br>

                <!--Log out button-->
                <button class="log-outbtn" onclick="goToIndex()"><a href="../index.html">Log out</a></button>
                <br><hr>

                <!--Transfer button-->
                <form action="../src/transfer/transfer.php" method="post">
                    <button class="money-buttons" type="submit">Transfer</button>
                </form><br>
                
                  <!--Between buttons text-->
                <div class="between-buttons-text">
                  <p>If you want to add more than 1000 BGN ,please contact us!</p>
                </div>
                
                <!--Add button-->
                <form action="../src/Deposit.php" method="post">
                  <button class="money-buttons" type="submit">Deposit</button>
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