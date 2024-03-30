
        


<?php
session_start(); // Start the session

if (isset($_POST['loginButton'])) {
    include('connection.php');  

    $mysqli = new mysqli($hostname, $db_username, $db_password, $db_name); 
    
    $email = $_POST['email'];  
    $password = $_POST['password'];  
    
    // To prevent SQL injection  
    $email = $mysqli->real_escape_string($email);
    $password = $mysqli->real_escape_string($password);  
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = $mysqli->query($sql);  

    if (!$result) {
        // Query execution failed
        echo "<h1> Login failed. Error executing the query.</h1>";
    } else {
        $count = $result->num_rows;  

        if ($count == 1) {  
            $row = $result->fetch_assoc();
            // $_SESSION["email"] = $row['email'];// Assuming 'username' is the column name for the user's username
            header('Location: EventUserPage.html');
            exit(); // Stop further execution
        } else {  
            echo "<script>alert('Login failed. Invalid username or password.');</script>"; // Display alert message
            echo "<script>window.location.href = 'EventHomePage.html';</script>"; // Redirect user after displaying alert
            exit; // Stop further execution
        }  
    }
}  
?>







