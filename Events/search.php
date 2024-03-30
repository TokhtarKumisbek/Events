<?php
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "eventinfo"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search functionality

// Debugging - Output the search query
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    echo "Search query: " . $search;
}

    // SQL query to fetch data based on search criteria
    $sql = "SELECT * FROM information WHERE OrgName LIKE '%$search%' OR EventName LIKE '%$search%' OR Description LIKE '%$search%' OR Date LIKE '%$search%' OR Category LIKE '%$search%' OR Location LIKE '%$search%' OR NameofOrg LIKE '%$search%' OR EmailofOrg LIKE '%$search%' OR PhoneofOrg LIKE '%$search%'";
    $result = $conn->query($sql);

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Output data in the format you desire
            echo "<div class='Events'>";
            echo "<div class='Image'></div>";
            echo "<div class='OrgName'><label>" . $row["OrgName"] . "</label></div> <br>";
            echo "<div class='EventName'><label>" . $row["EventName"] . "</label></div> <br>";
            echo "<div class='Description'><label>" . $row["Description"] . "</label></div> <br>";
            echo "<div class='Date'><label>" . $row["Date"] . "</label>   <label>" . $row["Location"] . "</label></div> <br> <br>";
            echo "<div class='Category'><label>" . $row["Category"] . "</label></div> <br>";
            echo "<div class='NameofOrg'><label>" . $row["NameofOrg"] . "</label></div> <br>";
            echo "<div class='EmailofOrg'><label>" . $row["EmailofOrg"] . "</label></div> <br>";
            echo "<div class='PhoneofOrg'><label>" . $row["PhoneofOrg"] . "</label></div> <br><hr>";
            echo "</div>";
        }
    } else {
        echo "0 results";
}


// Close connection
$conn->close();
?>
