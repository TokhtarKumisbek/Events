<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data from Database</title>
    <style>
        body {
            background-color: #FDF1E6;
        }
    </style>
    <link rel="stylesheet" href="EventsMain.css">
    <style>
        body {
            background-color: #FDF1E6;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        .header {
            padding-left: 112px;
            margin-left: -112px;
            height: 70px;
            width: 1423px;
            background-color: black;
        }

        
        .navbar{
            width: 1200px;
            height: 75px;
            margin: auto;
        }

        .icon{
            width: 300px;
            float: left;
            height: 70px;
        }

        .logo{
            color: #35747E;
            font-size: 30px;
            font-family: Arial;
            padding-left: 20px;
            float: left;
            padding-top: 10px;
        }

        .menu{
            width: 400px;
            float: left;
            height: 70px;
            
        }

        ul{
            float: left;
            display: flex;
            /* justify-content: center;
            align-items: center; */
        }

        ul li{
            list-style: none;
            margin-left: 62px;
            margin-top: 27px;
            font-size: 16px;
            
        }

        ul li a{
            text-decoration: none;
            color: white;
            font-family: Arial;
            font-weight: bold;
            transition: 0.4s ease-in-out;
            
        }

        ul li a:hover{
            color: #35747E;
        }

        .search{
            width: 330px;
            float: left;
            margin-left: 270px;
        
        
            
        }

        .srch{
            font-family: 'Times New Roman';
            width: 200px;
            height: 40px;
            background-color: transparent;
            border: 1px solid #35747E;
            margin-top: 13px;
            color: #B6B9C4;
            font-size: 16px;
            border-right: none;
            padding: 10px;
            border-bottom-left-radius: 5px; 
            border-top-left-radius: 5px;
            float:left;
        }


        .btn{
            height: 40px;
            width: 100px;
            background-color: #35747E;
            color:white;
            margin-top: 5px;
            border: 2px solid #35747E;
            font-size: 15px;
            font-family: Arial;
            margin-top: 13px;
            cursor: pointer;
            font-weight: bold;

            
        }

        .btn:focus{
            outline: none;
        }

        .srch:focus{
            outline: none;
        }
        
        /* Add any additional styles that are needed */
    </style>
</head>
<body>
   
    <div class="navbar">
        <div class="header">
            <div class="icon">
                <h2 class="logo">Events</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="Events.php">EVENTS</a></li>
                    <li><a href="EventRegistrationPage.html">Contact Us</a></li>
                    <li><a href="Login.html">Login</a></li>
                </ul>
            </div>

            <div class="search">
                <input class="srch" type="text" id="searchInput" placeholder="type to search">
                <button class="btn" onclick="search()">Search</button>
            </div>

            <div id="searchResults"></div>

        </div>
    </div>



    <!-- <div>
        <input type="text" id="searchInput" placeholder="Search...">
        <button onclick="search()">Search</button>
    </div>

    <div id="searchResults"></div> -->


    <!-- Add select element for category filtering -->
    <select name="category_filter" id="category_filter" onchange="filterByCategory()">
        <option value="">--Select Category--</option>
        <option value="STEM">STEM</option>
        <option value="Entertainment">Entertainment</option>
        <option value="Social">Social</option>
        <!-- Add more options as needed -->
    </select>

    



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

// SQL query to fetch data from the database
$sql = "SELECT * FROM information";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Output data in the format you desire
        echo "<div class='Events' data-category='" . $row["Category"] . "'>";
         // Check if there is a picture for the event and display it
         if ($row["Picture"]) {
            // Detect MIME Type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($row["Picture"]);
            
            echo "<div class='Image'><img src='data:" . $mimeType . ";base64," . base64_encode($row["Picture"]) . "' alt='Event Image' style='width:100%;height:auto;'></div>";
        } else {
            echo "<div class='Image'>No image available</div>";
        }
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

<script>

function search() {
    var searchQuery = document.getElementById("searchInput").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php?search=" + searchQuery, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var searchResults = xhr.responseText;
            // Hide all events initially
            var events = document.getElementsByClassName("Events");
            for (var i = 0; i < events.length; i++) {
                events[i].style.display = "none";
            }
            // Show only the search results
            document.getElementById("searchResults").innerHTML = searchResults;
        }
    };
    xhr.send();
}


// Function to filter events by category
function filterByCategory() {
    var category = document.getElementById("category_filter").value;
    var events = document.getElementsByClassName("Events");
    for (var i = 0; i < events.length; i++) {
        var eventCategory = events[i].getAttribute("data-category");
        if (category === '' || eventCategory === category) {
            events[i].style.display = "block";
        } else {
            events[i].style.display = "none";
        }
    }
}

document.getElementById("sortForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var sortValue = document.getElementById("sort_alphabet").value;
    var searchParams = new URLSearchParams(window.location.search);
    searchParams.set("sort_alphabet", sortValue);
    window.location.search = searchParams.toString();
});

// Call filterByCategory initially to display all events
filterByCategory();

</script>

</body>
</html>

