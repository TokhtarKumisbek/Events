<?php
    $hostname = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "registeruser"; // Replace with your actual database name

    // Create connection
    $mysqli = new mysqli($hostname, $db_username, $db_password, $db_name);

    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Close the connection when done
    $mysqli->close();
?>
