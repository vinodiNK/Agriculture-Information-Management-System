<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aims";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current username and role
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $currentPassword = $_POST['current_password'];
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
 

    // TODO: Add validation and check for current password correctness

    // Update the database with the new username, password, and role
$stmt = $conn->prepare("UPDATE users SET username=?, password=? WHERE username=?");
$stmt->bind_param("sss", $newUsername, $newPassword, $username);


    if ($stmt->execute()) {
        // Success
        header("Location: changepassword_success.php");
        exit();
    } else {
        // Error
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Username and Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <h2>Change Username and Password</h2>
            <p>Current Username: <?php echo $username; ?></p>
            <p>Current Role: <?php echo $role; ?></p>

            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required>

            <label for="new_username">New Username:</label>
            <input type="text" name="new_username" required>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>

            

            <button type="submit">Change Username and Password</button>
        </form>
    </div>
</body>
</html>
