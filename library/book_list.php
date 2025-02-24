<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=library_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the database
    $stmt = $pdo->prepare("SELECT * FROM books");
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .edit-btn {
            background-color: #f39c12;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        .edit-btn:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <h1>Book List</h1>
    <table>
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Available Copies</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['BookID']); ?></td>
                    <td><?php echo htmlspecialchars($book['Title']); ?></td>
                    <td><?php echo htmlspecialchars($book['Author']); ?></td>
                    <td><?php echo htmlspecialchars($book['Genre']); ?></td>
                    <td><?php echo htmlspecialchars($book['AvailableCopies']); ?></td>
                    <td>
                        <a href="edit_book.php?BookID=<?php echo $book['BookID']; ?>" class="edit-btn">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
