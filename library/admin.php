<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "library_db";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Failed to connect to DB: " . $conn->connect_error);
}

// Handle User Registration
if (isset($_POST['signUp'])) {
  $firstName = trim($_POST['first_name']);
  $lastName = trim($_POST['last_name']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  // Check if email already exists
  $stmt = $conn->prepare("SELECT CustomerID FROM customers WHERE Email = ?");
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
      echo "<script>alert('Email already exists! Try logging in.');</script>";
  } else {
      $stmt = $conn->prepare("INSERT INTO customers (FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?)");
      if (!$stmt) {
          die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
      if ($stmt->execute()) {
          echo "<script>alert('Registration successful! Please log in.'); window.location.href='admin.php';</script>";
      } else {
          echo "<script>alert('Error registering user.');</script>";
      }
  }
}

// Handle User Login
if (isset($_POST['signIn'])) {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $stmt = $conn->prepare("SELECT CustomerID, FirstName, LastName, Password FROM customers WHERE Email = ?");
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
      $stmt->bind_result($id, $fname, $lname, $hashedPassword);
      $stmt->fetch();

      if (password_verify($password, $hashedPassword)) {
          $_SESSION['user_id'] = $id;
          $_SESSION['user_name'] = $fname . " " . $lname;
          $_SESSION['user_email'] = $email;

          echo "<script>alert('Login successful! Welcome, $fname $lname (Email: $email)'); window.location.href='customer.php';</script>";
      } else {
          echo "<script>alert('Incorrect password!');</script>";
      }
  } else {
      echo "<script>alert('Account does not exist! Please register first.');</script>";
  }
}

// Handle Admin Login
if (isset($_POST['adminLogin'])) {
  $adminUser = trim($_POST['adminUser']);
  $adminPass = trim($_POST['adminPassword']);

  // Dummy credentials for admin (Replace with DB validation)
  if ($adminUser == "admin" && $adminPass == "admin123") {
      $_SESSION['admin'] = $adminUser;
      echo "<script>alert('Admin login successful!'); window.location.href='dashboard.php';</script>";
  } else {
      echo "<script>alert('Invalid admin credentials!');</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="admin.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="first_name" placeholder="First Name" required>
           <label for="fname">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <label for="lname">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      <p class="or">
        ----------or--------
      </p>
      
      <div class="links">
        <p>Already Have Account?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="admin.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <div class="links">
          <p>Don't have an account yet?</p>
          <button id="signUpButton">Sign Up</button>
        </div>
        
        <div class="admin-link">
          <p>Admin?</p>
          <button id="adminLoginButton">Admin Login</button>
        </div>
      </div>

      <div class="container" id="adminLogin" style="display:none;">
        <h1 class="form-title">Admin Login</h1>
        <form method="post" action="admin.php">
          <div class="input-group">
              <i class="fas fa-user-shield"></i>
              <input type="text" name="adminUser" placeholder="Admin Username" required>
              <label for="adminuser">Admin</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="adminPassword" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
         <input type="submit" class="btn" value="Login" name="adminLogin">
        </form>
        <div class="links">
          <p>Back to User Login?</p>
          <button id="backToUserLogin">User Login</button>
        </div>
      </div>
        <script src="script.js"></script>
</body>
</html>


