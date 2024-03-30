

<?php
//  Database connection details
$hostname = "localhost";
$db_username = "root";
 $db_password = "";
 $db_name = "eventinfo";

// Create connection
 $conn = new mysqli($hostname, $db_username, $db_password, $db_name);

  // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

//  Check if the form was submitted
if(isset($_POST['Publish'])) {
    // ... (Keep the existing code for text data)

    // Check if a file has been uploaded
    if (isset($_FILES['Picture']) && $_FILES['Picture']['error'] == 0) {
        // Assign variables for the uploaded file
        $imageName = $_FILES['Picture']['name'];
        $imageTmpName = $_FILES['Picture']['tmp_name'];
        $imageSize = $_FILES['Picture']['size'];
        $imageError = $_FILES['Picture']['error'];
        $imageType = $_FILES['Picture']['type'];
        
        // Check if file is an image
        $imageExt = strtolower(end(explode('.', $imageName)));
        $allowedExt = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($imageExt, $allowedExt)) {
            if ($imageError === 0) {
                if ($imageSize < 1000000) { // Check if the file is less than ~1MB
                    // Set the destination path for the image
                    $imageNameNew = uniqid('', true) . "." . $imageExt;
                    $imageDestination = 'uploads/' . $imageNameNew;
                    move_uploaded_file($imageTmpName, $imageDestination);

                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        // Check if the file exists in the destination
                        if (file_exists($imageDestination)) {
                            echo "File uploaded successfully.";
                            
                    // Now you have a path to store in the database
                } else {
                    echo "Failed to upload file";
                }
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
}
    
    // Modify the SQL to include the picture path
    $sql = "INSERT INTO information (OrgName, EventName, Date, Category, Description, Location, NameofOrg, EmailofOrg, PhoneofOrg, Picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    // Add the image path as a new parameter
    $stmt->bind_param("ssssssssss", $orgName, $eventName, $date, $category, $description, $location, $nameofOrg, $emailofOrg, $phoneofOrg, $imageDestination);
    
    //  Get values from the form submission
     $orgName = $_POST["OrgName"];
     $eventName = $_POST["EventName"];
     $date = $_POST["Date"];
     $category = $_POST["Category"];
     $description = $_POST["Description"];
     $location = $_POST["Location"];
     $nameofOrg = $_POST["NameofOrg"];
     $emailofOrg = $_POST["EmailofOrg"];
     $phoneofOrg = $_POST["PhoneofOrg"];
    
    //  Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully";
       header('Location: EventUserPage.html');
    } else {
      echo "Error: " . $conn->error;
    }
    
    // Close the statement
    $stmt->close();
 }

//  Close the connection
 $conn->close();
?>