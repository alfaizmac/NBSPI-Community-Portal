<?php
include_once 'connect.php'; // Database connection

if (isset($_POST['submit'])) {
    $user_name = $_POST['user_name'];
    $description = $_POST['discription'];

    // Upload images
    $uploadDirectory = "uploads/"; // Directory where images will be saved

    // Check if the directory exists, if not create it
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true); // Create the directory if it doesn't exist
    }

    if (!is_writable($uploadDirectory)) {
        die("The upload directory is not writable. Please check the permissions.");
    }

    $filePaths = []; // Array to store paths of uploaded images

    foreach ($_FILES['filesToUpload']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['filesToUpload']['name'][$key]);
        $targetFilePath = $uploadDirectory . $fileName;

        // Check if the file is an image
        if (getimagesize($tmpName) !== false) {
            // Attempt to move the uploaded file to the desired directory
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $filePaths[] = $targetFilePath;
            } else {
                echo "Error uploading file: " . $fileName;
            }
        } else {
            echo "File is not an image: " . $fileName;
        }
    }

    // Insert post details into the database
    if (!empty($filePaths)) {
        $photoPaths = implode(',', $filePaths); // Store multiple image paths as a comma-separated string

        $query = "INSERT INTO posts (username, description, photo) VALUES ('$user_name', '$description', '$photoPaths')";
        if (mysqli_query($conn, $query)) {
            header("Location: feed.php?username=$user_name");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
