<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASP Library Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        .sidebar {
            width: 20%;
            height: 100%;
            background-color: #003366;
            color: white;
            float: left;
        }
        .main-content {
            width: 80%;
            height: 100%;
            float: left;
        }
        .menu-item {
            padding: 15px;
            text-decoration: none;
            color: white;
            display: block;
        }
        .menu-item:hover {
            background-color: #0055a5;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-center">ASP MENU</h3>
        <a href="home.php" target="main" class="menu-item">Home</a>
        <a href="custpage.php" target="main" class="menu-item">Customers for Approval</a>
        <a href="approve.php" target="main" class="menu-item">Approved Customers</a>
        <a href="reject.php" target="main" class="menu-item">Rejected Customers</a>
        <a href="cust.php" target="main" class="menu-item">Customers Registered</a>
        <a href="admin_books.php" target="main" class="menu-item">All Books in Library</a>
        <a href="addbooks.php" target="main" class="menu-item">Add Books</a>
        <a href="issue.php" target="main" class="menu-item">Issue / Return Books</a>
        <a href="borrowed.php" target="main" class="menu-item">View All Issued Books</a>
        <a href="logout.php" class="menu-item">Logout</a>
    </div>
    <div class="main-content">
        <iframe name="main" src="home.php"></iframe>
    </div>
</body>
</html>
