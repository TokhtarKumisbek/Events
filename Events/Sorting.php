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

// Sorting logic based on the selected option
$sort = "";
if(isset($_GET['sort_alphabet'])) {
    if($_GET['sort_alphabet'] == 'a-z') {
        $sort = " ORDER BY OrgName ASC";
    } elseif($_GET['sort_alphabet'] == 'z-a') {
        $sort = " ORDER BY OrgName DESC";
    }
}

// SQL query to fetch data from the database with sorting applied
$sql = "SELECT * FROM information" . $sort;
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
