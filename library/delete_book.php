<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['BookID'])) {
    $bookID = $_GET['BookID'];

    // Check if the book is issued
    $checkSQL = "SELECT * FROM borrowedbooks WHERE BookID = ? AND Status = 'Issued'";
    $stmt = $conn->prepare($checkSQL);
    $stmt->bind_param("i", $bookID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If book is issued, make it inactive
        $updateSQL = "UPDATE books SET Active = 0 WHERE BookID = ?";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("i", $bookID);
        $stmt->execute();

        echo "✅ Book is currently issued, so it has been marked as inactive.";
    } else {
        // If book is not issued, delete it
        $deleteSQL = "DELETE FROM books WHERE BookID = ?";
        $stmt = $conn->prepare($deleteSQL);
        $stmt->bind_param("i", $bookID);
        $stmt->execute();

        echo "✅ Book deleted successfully.";
    }

    $stmt->close();
}

$conn->close();
?>
