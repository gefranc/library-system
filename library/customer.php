
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard</title>
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
        <a href="edit_profile.php" target="main" class="menu-item">Edit</a>
        <a href="book_list.php" target="main" class="menu-item">All Books</a>
        <a href="borrow.php" target="main" class="menu-item">Borrow Books</a>
        <a href="borrowed.php" target="main" class="menu-item">Borrowed Books</a>
        <a href="logout.php" class="menu-item">Logout</a>
    </div>
    <div class="main-content">
        <iframe name="main" src="home.php"></iframe>
    </div>
</body>
</html>
