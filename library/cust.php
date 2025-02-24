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

$sql = "SELECT CustomerID, FirstName, LastName, Email FROM Customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<h1>Customer Information</h1>

<table>
    <tr>
        <th>CustID</th>
        <th>FirstName</th>
        <th>LastName</th>
        <th>Email</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["CustomerID"]. "</td>
                    <td>" . $row["FirstName"]. "</td>
                    <td>" . $row["LastName"]. "</td>
                    <td>" . $row["Email"]. "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No customers found</td></tr>";
    }
    $conn->close();
    ?>
</table>

</body>
</html>
