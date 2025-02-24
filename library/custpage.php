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

// Handle Approve action
if (isset($_POST['approve'])) {
    $customerID = $_POST['customer_id'];
    $conn->query("UPDATE customers SET Approved = 1 WHERE CustomerID = $customerID");
}

// Handle Reject action
if (isset($_POST['reject'])) {
    $customerID = $_POST['customer_id'];
    $conn->query("UPDATE customers SET Approved = -1 WHERE CustomerID = $customerID");
}

// Fetch customers pending approval
$sql = "SELECT CustomerID, FirstName, LastName, Email FROM customers WHERE Approved = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Approval</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 15px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .approve-btn { background-color: #28a745; color: white; padding: 5px 10px; border: none; cursor: pointer; }
        .reject-btn { background-color: #dc3545; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h1>Customer Approval</h1>

<table>
    <tr>
        <th>CustID</th>
        <th>FirstName</th>
        <th>LastName</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row["CustomerID"]}</td>
                    <td>{$row["FirstName"]}</td>
                    <td>{$row["LastName"]}</td>
                    <td>{$row["Email"]}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='customer_id' value='{$row["CustomerID"]}'>
                            <button type='submit' name='approve' class='approve-btn'>Approve</button>
                        </form>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='customer_id' value='{$row["CustomerID"]}'>
                            <button type='submit' name='reject' class='reject-btn'>Reject</button>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No customers awaiting approval</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
