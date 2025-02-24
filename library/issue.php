<?php
session_start();

// Database connection
$dsn = 'mysql:host=localhost;dbname=library_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['issue_book'])) {
        $CustomerID = trim($_POST['CustomerID']);
        $BookID = trim($_POST['BookID']);
        $borrowedDate = date("Y-m-d");
        $returnDate = date("Y-m-d", strtotime("+14 days")); // 14-day return period

        // Check if customer exists and is approved
        $stmt = $pdo->prepare("SELECT Approved FROM customers WHERE CustomerID = ?");
        $stmt->execute([$CustomerID]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            echo "<script>alert('Invalid Customer ID!');</script>";
        } elseif ($customer['Approved'] != 1) {
            echo "<script>alert('Customer is not approved to borrow books!');</script>";
        } else {
            // Check book availability
            $stmt = $pdo->prepare("SELECT AvailableCopies FROM books WHERE BookID = ?");
            $stmt->execute([$BookID]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book && $book['AvailableCopies'] > 0) {
                // Issue the book
                $stmt = $pdo->prepare("INSERT INTO borrowedbooks (CustomerID, BookID, BorrowedDate, ReturnDate, Status) 
                                       VALUES (?, ?, ?, ?, 'Borrowed')");
                $stmt->execute([$CustomerID, $BookID, $borrowedDate, $returnDate]);

                // Decrease available copies
                $stmt = $pdo->prepare("UPDATE books SET AvailableCopies = AvailableCopies - 1 WHERE BookID = ?");
                $stmt->execute([$BookID]);

                echo "<script>alert('Book issued successfully! Return by $returnDate'); window.location.href='';</script>";
            } else {
                echo "<script>alert('Book is not available!');</script>";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return_book'])) {
        $BookID = trim($_POST['return_BookID']);
        
        // Check if the book is borrowed
        $stmt = $pdo->prepare("SELECT * FROM borrowedbooks WHERE BookID = ? LIMIT 1");
        $stmt->execute([$BookID]);
        $borrowedBook = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($borrowedBook) {
            // Return the book
            $stmt = $pdo->prepare("DELETE FROM borrowedbooks WHERE BookID = ? LIMIT 1");
            $stmt->execute([$BookID]);

            // Increase available copies
            $stmt = $pdo->prepare("UPDATE books SET AvailableCopies = AvailableCopies + 1 WHERE BookID = ?");
            $stmt->execute([$BookID]);

            echo "<script>alert('Book returned successfully!'); window.location.href='';</script>";
        } else {
            echo "<script>alert('Book was not borrowed!');</script>";
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
    <title>Issue/Return Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h2>Issue a Book</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="CustomerID">Customer ID</label>
                    <input type="text" id="CustomerID" name="CustomerID" required>
                </div>
                <div class="form-group">
                    <label for="BookID">Book ID</label>
                    <input type="text" id="BookID" name="BookID" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="issue_book">Issue Book</button>
                </div>
            </form>
        </div>

        <div class="form-section">
            <h2>Return a Book</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="return_BookID">Book ID</label>
                    <input type="text" id="return_BookID" name="return_BookID" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="return_book">Return Book</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
