<?php
//Connection
$conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

if ($conn->connect_error)
{
    die('Connection Failed : '. $conn->connect_error);
}

session_start();

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    //Gets user credentials from DB
    $query = "SELECT * FROM users WHERE email = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) 
    {
        $user = $result->fetch_assoc();

        // Store the IBAN in a session variable
        $_SESSION['user_iban'] = $user['iban'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_bal'] = $user['bal'];
  
        // Assign the IBAN to a variable for future use in this script
        $iban = $user['iban'];
  
        $bal = $user['bal'];

        //Redirect to a page where you are logged in and site functions
        header("Location: ../html/Logged.php");
    }
     else 
    {
        echo
        '
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
          <a class="navbar-brand" href="../index.html">
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
                <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>

  <!--Login Card-->
  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/login.php" method="post">
        <div class="container">
          <h1 style="font-weight: bold;">Login</h1>
          <h3 style="font-weight: bold;">Login Failed: Invalid Email or Password</h3>
          <hr>

          <form action="../php/login.php" method="post">

          <input type="text" placeholder="Email" name="email" id="email" required>
          <br><br>

          <input type="password" placeholder="Password" name="pass" id="pass" required>
          <br>

          <a href="#" class="card-link" id="fp" style="font-weight: bold;">Forgot password</a>
          <br>

          <button type="submit" class="registerbtn" >Log in</button>
          </form>

          <br><br>
          <p id="or"><span>or</span></p>
          <a href="../html/Register.html" class="card-link">Create an Account</a>
        
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }

    $stmt->close();
?>
