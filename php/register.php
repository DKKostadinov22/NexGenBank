<?php
    //Connection
    $conn = new mysqli('78.128.11.228', 'ngb', 'dbpass1234', 'ngb_db');

    if ($conn->connect_error)
    {   
        die('Connection Failed : '. $conn->connect_error);
    }

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_repeat = $_POST['pass_repeat'];

    // Function to generate a random IBAN
    function generateRandomIBAN() 
    {
    $countryCode = "BG"; // Change to appropriate country code
    $randomNumbers = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    $iban = $countryCode . $randomNumbers;
    return $iban;
    }

    $iban = generateRandomIBAN(); // Generate IBAN
    $bal = 0;

    //Checks to see if username, email or phone number already exist in the db
    $check = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username'");
    $check2 = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
    $check3 = mysqli_query($conn, "SELECT * FROM `users` WHERE phone_number = '$phone_number'");

    //Initializes every part that should be included in the password
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);
    $specialChars = preg_match('@[^\w]@', $pass);

    //Initializes the phone number pattern
    $pattern = "/^08[789][0-9]{7}$/";

    //DB formatting, and filtering
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: The E-Mail address is NOT valid!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else if (!preg_match($pattern, $phone_number)) 
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: The phone number is not valid!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else if($pass != $pass_repeat)
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: The passwords do not match!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) 
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: The password does not meet the requirements!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else if(mysqli_num_rows($check) > 0)
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: Username already in use!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else if(mysqli_num_rows($check2) > 0)
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: Email already in use!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else if(mysqli_num_rows($check3) > 0)
    {
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Failed: Phone number already in use!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, gender, phone_number, username, email, pass, iban, bal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssi", $first_name, $last_name, $gender, $phone_number, $username, $email, $pass, $iban, $bal);
        $stmt->execute();
        echo
        '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Register.css">
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
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item" id="nav-item-icon">
                <img src="../images/pngegg.png">
              </li>
            </ul>
          </div>
        </div>
  </nav>


  <div class="card text-center" id="card-body">
    <div class="card-body">
      <form action="../php/register.php" method="post">
        <div class="container">
          <h1>Register</h1>
          <p>Please fill in this form to create an account.</p>
          <h3>Registration Successful!</h3>
          <hr>
      
          <label for="first_name"></label>
          <input type="text" placeholder="Enter your first name" name="first_name" id="first_name" required>
          <br><br>

          <label for="last_name"></label>
          <input type="text" placeholder="Enter your last name" name="last_name" id="last_name" required>
          <br><br>

          <label for="gender"></label>
          <select name="gender" id="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          <option value="O">Other</option>
          </select><br><br>

          <label for="phone_number"></label>
          <input type="text" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
          <br><br>
          
          <label for="usename"></label>
          <input type="text" placeholder="Enter Username" name="username" id="username" required>
          <br><br>

          <label for="email"></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" required>
          <br><br>

          <label for="pass"></label>
          <p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
          <input type="password" placeholder="Enter Password" name="pass" id="pass" required>
          <br><br>


          <label for="pass_repeat"></label>
          <input type="password" placeholder="Repeat Password" name="pass_repeat" id="pass_repeat" required>
          <hr>
      
          <p>By creating an account you agree to our <a href="#" class="card-link">Terms & Privacy</a>.</p>
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Already have an account? <a href="../index.html" class="card-link">Sign in</a>.</p>
        </div>
      </form> 
    </div>
  </div>

</body>
</html>
        ';
        $stmt->close();
        $conn->close();
    }
?>