<?php
// Database connection
$servername = "localhost";
$username = "root";
$password ="";
$dbname = "submission";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Check if the submission already exists
$sql = "SELECT * FROM customer WHERE name = ? OR email = ? OR phone = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error: " . $conn->error);
}

$stmt->bind_param("sss", $name, $email, $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "You have already submitted this information.";
} else {
    // Insert submission into the database
    $sql = "INSERT INTO customer (name, email, phone, submission_time) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $phone);
    
    if ($stmt->execute()) {
        echo "Welcome, $name! Your submission has been recorded.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$stmt->close();
$conn->close();
?>

