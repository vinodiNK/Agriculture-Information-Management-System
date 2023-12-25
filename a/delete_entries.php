<?php
// Connect to your database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "aims";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteAll']) && $_POST['deleteAll'] == "true") {
    // SQL query to delete all entries from the "fertilizer" table
    $sql = "DELETE FROM fertilizer";

    if ($conn->query($sql) === TRUE) {
        // Echo a success message
        echo "Success";
    } else {
        // Echo an error message
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<?php
if (isset($_POST['deleteEntry'])) {
    $landNumber = $_POST['landNumber'];

    // Connect to your database (replace with your credentials)
    $conn = new mysqli("localhost", "root", "", "aims");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the delete query
    $sql = "DELETE FROM fertilizer WHERE land_number = '$landNumber'";
    if ($conn->query($sql) === TRUE) {
        echo "Entry deleted successfully";
    } else {
        echo "Error deleting entry: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

