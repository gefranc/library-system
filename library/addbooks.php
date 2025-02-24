<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=library_db';
$username = 'root';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO books (Title, Author, Genre, AvailableCopies) VALUES (:title, :author, :genre, :availableCopies)");
        $stmt->bindParam(':title', $_POST['title']);
        $stmt->bindParam(':author', $_POST['author']);
        $stmt->bindParam(':genre', $_POST['Genre']);
        $stmt->bindParam(':availableCopies', $_POST['issues'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                alert('Book added successfully!');
                window.location.href = 'book_list.php';
            </script>";
        } else {
            echo "<script>alert('Error adding book!');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add a New Book</h2>
    <form action="addbooks.php" method="post">
        <div class="form-group">
            <label for="title">Title of Book</label>
            <input type="text" id="title" name="title" placeholder="Enter book title..." required>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" placeholder="Enter author's name..." required>
        </div>
        <div class="form-group">
            <label for="Genre">Genre</label>
            <select id="Genre" name="Genre" required>
                <option value="Sci-Fi">Sci-Fi</option>
                <option value="Horror">Horror</option>
                <option value="Fiction">Fiction</option>
                <option value="Romance">Romance</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Classics">Classics</option>
                <option value="Philosophy">Philosophy</option>
            </select>
        </div>
        <div class="form-group">
            <label for="issues">Available Copies</label>
            <input type="number" id="issues" name="issues" min="1" max="100" placeholder="Enter number of copies..." required>
        </div>
        <button type="submit">Add Book</button>
    </form>
</div>

</body>
</html>
