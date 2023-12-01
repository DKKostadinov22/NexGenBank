<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <title>NGB</title>
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
<!--Navbar-->
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
                <a class="nav-link active" aria-current="page" href="./Logged_verified.php">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>

  <!--Login Card-->
  <h1>Logged in as: </h1>

  <?php

  session_start();

  $iban = $_SESSION['user_iban'];
  $email = $_SESSION['user_email'];
  $bal = $_SESSION['user_bal'];

  echo $email;
  echo "<br> <h1>IBAN: </h1>";

  echo $iban;
  echo "<br> <h1>Balance: </h1>";

  echo $bal;
  echo "<h6>BGN</h6> <br>"

  ?>
  
  <br>
  <a href="../index.html">Log out</a> <br><br>

  <form action="./transfer.php" method="post">
  <button type="submit">Transfer</button>
  </form>

</body>
</html>