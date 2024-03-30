<?php

$notification = ""; // Initialize notification variable

if(isset($_POST['registerButton'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['passwordConfirmation']; // New variable to hold confirmation password

    // Check if passwords match
    if ($password !== $passwordConfirmation) {
        $notification = "Passwords do not match.";
    } else {
        $hostname = "localhost";
        $db_username = "root";
        $db_password = ""; // Corrected variable name for database password
        $db_name = "registeruser"; // Replace "your_database_name" with your actual database name
     
        $mysqli = new mysqli($hostname, $db_username, $db_password, $db_name); // Corrected instantiation of MySQLi object
        
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Check if email already exists in the database
        $check_query = "SELECT * FROM users WHERE email='$email'";
        $result = $mysqli->query($check_query);
        if ($result->num_rows > 0) {
            $notification = "This email account is already registered.";

        } else {
            // Email doesn't exist, proceed with registration
            $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

            if ($mysqli->query($query) === TRUE) {
                $notification = "Registration Successful.";
                header('Location: EventHomePage.html');
            } 
            else {
                echo "Error: " . $query . "<br>" . $mysqli->error;
            }
        }

        $mysqli->close();
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventTimes</title>
    <link rel="stylesheet" href="EventRegistrationPage.css" > 
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: orange;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: <?php echo ($notification != "") ? "block" : "none"; ?>;
        }
    </style>
</head>
<body>

<div class="notification" id="registrationNotification"><?php echo $notification;  ?></div>

<div class="begin">Event Times</div>
    <hr>
    <div class="wrapper">
        <div class="title"><span>Sign in</span></div>
        <form method="post" action="Registration.php">
            <div class="row">
                <input class="type" placeholder="Enter your email here" name="email" required>
            
            </div>

            <div class="row">
                <input type="password" placeholder="Enter your password here" name="password" required>
            
            </div>

            <div class="row">
                <input type="password" placeholder="Confirm your password " name="passwordConfirmation" required>
            
            </div>

            <div class="pass"><a href="#">Forgot Password?</a></div>

            <button type="submit" class="btn" name="registerButton" >Next</button>

            <div >Need to create an account? <button class="SignUp-link"><a href="#"> Contact Us</a></button> </div> <br>

            <div class="question">Have a question? Visit the <a href="#">ET Help Centre</a></div>

        </form>
        </div> 
      
        <hr>

        <div class="end">
            <div class="contacts">Contacts on social media</div> 
            <div class="copyright">Copyright Event Times. All rights reserved.</div>
            <div class="subscribe">Subscribe for newsletters</div>  
            <input type="text" class="email" placeholder="E-mail">
            <button class="rightbtn"><a href="#"><ion-icon name="logo-instagram"></ion-icon></a></button>

        </div>
     
        <div class="icons">
            <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#"><ion-icon name="logo-whatsapp"></ion-icon></a>
            <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#"><ion-icon name="logo-skype"></ion-icon></a>
            
        </div>

        <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>




<script>
    // Hide notification after 5 seconds
    setTimeout(function() {
        document.getElementById("registrationNotification").style.display = "none";
    }, 5000);
</script>

</body>
</html>
