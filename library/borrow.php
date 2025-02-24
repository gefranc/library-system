<?php
session_start();

// Database connection using PDO
$host = "localhost";
$dbname = "library_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize message
$message = "";

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerID = trim($_POST['customer_id']);
    $bookID = trim($_POST['book_id']);
    $bookTitle = trim($_POST['title']);
    $borrowedDate = date("Y-m-d"); // Today's date
    $returnDate = date("Y-m-d", strtotime("+14 days")); // 14-day return period

    try {
        // Check if customer exists and is approved
        $stmt = $pdo->prepare("SELECT Approved FROM customers WHERE CustomerID = ?");
        $stmt->execute([$customerID]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            $_SESSION["message"] = "❌ Invalid Customer ID.";
        } elseif ($customer['Approved'] != 1) {
            $_SESSION["message"] = "❌ Customer not approved to borrow books.";
        } else {
            // Check if the book exists, is active, and has copies available
            $stmt = $pdo->prepare("SELECT AvailableCopies FROM books WHERE BookID = ? AND Title = ? AND Active = 1 AND AvailableCopies > 0");
            $stmt->execute([$bookID, $bookTitle]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                // Insert borrow record
                $stmt = $pdo->prepare("INSERT INTO borrowedbooks (CustomerID, BookID, BorrowedDate, ReturnDate, Status) VALUES (?, ?, ?, ?, 'Borrowed')");
                $stmt->execute([$customerID, $bookID, $borrowedDate, $returnDate]);

                // Reduce available copies
                $stmt = $pdo->prepare("UPDATE books SET AvailableCopies = AvailableCopies - 1 WHERE BookID = ?");
                $stmt->execute([$bookID]);

                $_SESSION["message"] = "✅ Book borrowed successfully! Return by " . $returnDate;
            } else {
                $_SESSION["message"] = "❌ Book is unavailable or inactive.";
            }
        }
    } catch (PDOException $e) {
        $_SESSION["message"] = "Error: " . $e->getMessage();
    }

    // Redirect back to avoid form resubmission
    header("Location: borrow.php");
    exit();
}

// Retrieve the message from session (if any) and clear it
if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow a Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .form-group button:hover {
            background-color: #555;
        }
        .message {
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #e7f3e7;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Borrow a Book</h2>
        <form action="borrow.php" method="post">
            <div class="form-group">
                <label for="customer_id">Customer ID</label>
                <input type="text" id="customer_id" name="customer_id" required>

                <label for="book_id">Book ID</label>
                <input type="text" id="book_id" name="book_id" required>

                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <button type="submit">Borrow Book</button>
            </div>
        </form>
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
