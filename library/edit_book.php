<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=library_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if BookID is provided in the URL
    if (isset($_GET['BookID'])) {
        $BookID = $_GET['BookID'];

        // Fetch book details
        $stmt = $pdo->prepare("SELECT * FROM books WHERE BookID = :BookID");
        $stmt->bindParam(':BookID', $BookID);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            die("Book not found!");
        }
    } else {
        die("Invalid request!");
    }

    // Handle form submission for updating book details
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Title = $_POST['Title'];
        $Author = $_POST['Author'];
        $Genre = $_POST['Genre'];
        $AvailableCopies = $_POST['AvailableCopies'];

        // Update book record
        $stmt = $pdo->prepare("UPDATE books SET Title = :Title, Author = :Author, Genre = :Genre, AvailableCopies = :AvailableCopies WHERE BookID = :BookID");
        $stmt->bindParam(':Title', $Title);
        $stmt->bindParam(':Author', $Author);
        $stmt->bindParam(':Genre', $Genre);
        $stmt->bindParam(':AvailableCopies', $AvailableCopies);
        $stmt->bindParam(':BookID', $BookID);

        if ($stmt->execute()) {
            echo "<script>
                alert('Book updated successfully!');
                window.location.href = 'book_list.php'; // Redirect back to book list
            </script>";
        } else {
            echo "<script>alert('Error updating book!');</script>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 50%; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        .form-group button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .form-group button:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Book</h1>
        <form method="post">
            <div class="form-group">
                <label for="Title">Title</label>
                <input type="text" id="Title" name="Title" value="<?php echo htmlspecialchars($book['Title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Author">Author</label>
                <input type="text" id="Author" name="Author" value="<?php echo htmlspecialchars($book['Author']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Genre">Genre</label>
                <select id="Genre" name="Genre" required>
                    <option value="Sci-Fi" <?php if ($book['Genre'] == 'Sci-Fi') echo 'selected'; ?>>Sci-Fi</option>
                    <option value="Horror" <?php if ($book['Genre'] == 'Horror') echo 'selected'; ?>>Horror</option>
                    <option value="Fiction" <?php if ($book['Genre'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
                    <option value="Romance" <?php if ($book['Genre'] == 'Romance') echo 'selected'; ?>>Romance</option>
                    <option value="Fantasy" <?php if ($book['Genre'] == 'Fantasy') echo 'selected'; ?>>Fantasy</option>
                    <option value="Classics" <?php if ($book['Genre'] == 'Classics') echo 'selected'; ?>>Classics</option>
                    <option value="Philosophy" <?php if ($book['Genre'] == 'Philosophy') echo 'selected'; ?>>Philosophy</option>
                </select>
            </div>
            <div class="form-group">
                <label for="AvailableCopies">Available Copies</label>
                <input type="number" id="AvailableCopies" name="AvailableCopies" value="<?php echo htmlspecialchars($book['AvailableCopies']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Book</button>
            </div>
        </form>
    </div>
</body>
</html>
