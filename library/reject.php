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

// Fetch rejected customers
$sql = "SELECT CustomerID, FirstName, LastName, Email FROM customers WHERE Approved = -1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rejected Customers</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 15px; text-align: left; }
        th { background-color: #dc3545; color: white; }
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
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row["CustomerID"]}</td>
                    <td>{$row["FirstName"]}</td>
                    <td>{$row["LastName"]}</td>
                    <td>{$row["Email"]}</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No rejected customers</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
