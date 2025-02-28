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

// Approve a rejected customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_customer'])) {
    $CustomerID = $_POST['CustomerID'];

    // Update customer status to Approved (1)
    $updateSql = "UPDATE customers SET Approved = 1 WHERE CustomerID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("i", $CustomerID);

    if ($stmt->execute()) {
        echo "<script>alert('Customer Approved Successfully!'); window.location.href='';</script>";
    } else {
        echo "<script>alert('Error approving customer!');</script>";
    }
    $stmt->close();
}

// Fetch rejected customers
$sql = "SELECT CustomerID, FirstName, LastName, Email FROM customers WHERE Approved = -1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Customers</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 15px; text-align: left; }
        th { background-color: #dc3545; color: white; }
        .approve-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        .approve-btn:hover { background-color: #218838; }
    </style>
</head>
<body>

<h1>Rejected Customers</h1>

<table>
    <tr>
        <th>CustID</th>
        <th>FirstName</th>
        <th>LastName</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row["CustomerID"]}</td>
                    <td>{$row["FirstName"]}</td>
                    <td>{$row["LastName"]}</td>
                    <td>{$row["Email"]}</td>
                    <td>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='CustomerID' value='{$row["CustomerID"]}'>
                            <button type='submit' name='approve_customer' class='approve-btn'>Approve</button>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No rejected customers</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
