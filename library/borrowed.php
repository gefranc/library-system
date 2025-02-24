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

// Fetch borrowed books
$sql = "SELECT * FROM borrowedbooks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        table {
            background-color: white;
        }
        th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-returned {
            color: #28a745;
            font-weight: bold;
        }
        .status-overdue {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Borrowed Books</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer ID</th>
                    <th>Book ID</th>
                    <th>Borrowed Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Status Styling
                        $statusClass = "";
                        if ($row["Status"] == "Pending") {
                            $statusClass = "status-pending";
                        } elseif ($row["Status"] == "Returned") {
                            $statusClass = "status-returned";
                        } elseif ($row["Status"] == "Overdue") {
                            $statusClass = "status-overdue";
                        }

                        echo "<tr>
                                <td>{$row["TransactionID"]}</td>
                                <td>{$row["CustomerID"]}</td>
                                <td>{$row["BookID"]}</td>
                                <td>{$row["BorrowedDate"]}</td>
                                <td>{$row["ReturnDate"]}</td>
                                <td class='$statusClass'>{$row["Status"]}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No borrowed books found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
