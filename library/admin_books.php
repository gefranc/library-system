<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=library_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch books from the database
    $stmt = $pdo->prepare("SELECT * FROM books");
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if a book is issued
    $issuedBooksStmt = $pdo->prepare("SELECT BookID FROM borrowedbooks WHERE ReturnStatus = 'Borrowed'");
    $issuedBooksStmt->execute();
    $issuedBooks = $issuedBooksStmt->fetchAll(PDO::FETCH_COLUMN);

    // Handle delete request (mark as inactive)
    if (isset($_GET['delete'])) {
        $bookID = $_GET['delete'];

        // Prevent deletion if the book is currently issued
        if (in_array($bookID, $issuedBooks)) {
            echo "<script>alert('This book is currently issued and cannot be deactivated!'); window.location='admin_books.php';</script>";
            exit();
        }

        $updateStmt = $pdo->prepare("UPDATE books SET status = 'Inactive' WHERE BookID = ?");
        $updateStmt->execute([$bookID]);
        header("Location: admin_books.php");
        exit();
    }

    // Handle reactivation request (mark as active)
    if (isset($_GET['reactivate'])) {
        $bookID = $_GET['reactivate'];
        $updateStmt = $pdo->prepare("UPDATE books SET status = 'Active' WHERE BookID = ?");
        $updateStmt->execute([$bookID]);
        header("Location: admin_books.php");
        exit();
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
    <title>Admin - Book List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .edit-btn, .delete-btn, .reactivate-btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            color: white;
        }
        .edit-btn { background-color: #f39c12; }
        .edit-btn:hover { background-color: #e67e22; }
        .delete-btn { background-color: #e74c3c; }
        .delete-btn:hover { background-color: #c0392b; }
        .reactivate-btn { background-color: #27ae60; }
        .reactivate-btn:hover { background-color: #1e8449; }
        .inactive-btn {
            background-color: grey;
            cursor: not-allowed;
        }
        .active { color: green; font-weight: bold; }
        .inactive { color: red; font-weight: bold; }
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
                <th>Status</th>
                <th>Actions</th>
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
                        <span class="<?php echo ($book['status'] == 'Active') ? 'active' : 'inactive'; ?>">
                            <?php echo htmlspecialchars($book['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_book.php?BookID=<?php echo $book['BookID']; ?>" class="edit-btn">Edit</a>
                        
                        <?php if ($book['status'] == 'Active'): ?>
                            <?php if (in_array($book['BookID'], $issuedBooks)): ?>
                                <button class="delete-btn inactive-btn" disabled>Issued</button>
                            <?php else: ?>
                                <a href="?delete=<?php echo $book['BookID']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to deactivate this book?')">Delete</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="?reactivate=<?php echo $book['BookID']; ?>" class="reactivate-btn" onclick="return confirm('Are you sure you want to reactivate this book?')">Reactivate</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
