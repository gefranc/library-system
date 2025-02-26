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

    // Reactivate the book
    $sql = "UPDATE books SET Active = 1 WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookID);
    $stmt->execute();

    echo "<script>alert('Book reactivated successfully!'); window.location.href='admin_books.php';</script>";
}

$conn->close();
?>
