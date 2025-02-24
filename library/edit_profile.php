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

$message = "";

// Fetch user details when CustomerID is provided
$customerID = "";
$firstName = "";
$lastName = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch_details'])) {
    $customerID = $_POST['CustomerID'];

    $sql = "SELECT * FROM customers WHERE CustomerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row["FirstName"];
        $lastName = $row["LastName"];
        $email = $row["Email"];
    } else {
        $message = "❌ No customer found with this ID.";
    }
}

// Update user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $customerID = $_POST['CustomerID'];
    $firstName = trim($_POST['FirstName']);
    $lastName = trim($_POST['LastName']);
    $email = trim($_POST['Email']);

    if (!empty($firstName) && !empty($lastName) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $updateSQL = "UPDATE customers SET FirstName = ?, LastName = ?, Email = ? WHERE CustomerID = ?";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $customerID);

        if ($stmt->execute()) {
            $message = "✅ Profile updated successfully!";
        } else {
            $message = "❌ Error updating profile.";
        }
    } else {
        $message = "❌ Please enter valid details.";
    }
}

// Update password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $customerID = $_POST['CustomerID'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword && !empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updatePasswordSQL = "UPDATE customers SET Password = ? WHERE CustomerID = ?";
        $stmt = $conn->prepare($updatePasswordSQL);
        $stmt->bind_param("si", $hashedPassword, $customerID);

        if ($stmt->execute()) {
            $message = "✅ Password updated successfully!";
        } else {
            $message = "❌ Error updating password.";
        }
    } else {
        $message = "❌ New passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 5px; }
        h2 { margin-top: 0; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .form-group button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 5px; }
        .form-group button:hover { background-color: #45a049; }
        .message { margin-top: 10px; color: green; }
        .error { color: red; }
        .section { border-bottom: 1px solid #ddd; padding-bottom: 15px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Your Profile</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Fetch Customer Details -->
    <form action="edit_profile.php" method="post">
        <div class="form-group">
            <label for="CustomerID">Enter Customer ID</label>
            <input type="text" id="CustomerID" name="CustomerID" required value="<?= htmlspecialchars($customerID); ?>">
        </div>
        <div class="form-group">
            <button type="submit" name="fetch_details">Fetch Details</button>
        </div>
    </form>

    <!-- Profile Update Form -->
    <?php if (!empty($firstName) || !empty($lastName) || !empty($email)): ?>
        <div class="section">
            <form action="edit_profile.php" method="post">
                <input type="hidden" name="CustomerID" value="<?= htmlspecialchars($customerID); ?>">
                
                <div class="form-group">
                    <label for="FirstName">First Name</label>
                    <input type="text" id="FirstName" name="FirstName" required value="<?= htmlspecialchars($firstName); ?>">
                </div>

                <div class="form-group">
                    <label for="LastName">Last Name</label>
                    <input type="text" id="LastName" name="LastName" required value="<?= htmlspecialchars($lastName); ?>">
                </div>

                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" id="Email" name="Email" required value="<?= htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <button type="submit" name="update_profile">Update Profile</button>
                </div>
            </form>
        </div>

        <!-- Password Update Form -->
        <div class="section">
            <h2>Change Password</h2>
            <form action="edit_profile.php" method="post">
                <input type="hidden" name="CustomerID" value="<?= htmlspecialchars($customerID); ?>">

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-group">
                    <button type="submit" name="update_password">Update Password</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
