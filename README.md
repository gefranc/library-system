# 📚 Library Management System

## 📖 Overview

The **Library Management System** is a web-based application designed to manage a library's operations efficiently. It allows users to register, borrow books, track due dates, and return books. Admins can manage book records, issue/return books, and send notifications.

## 🚀 Features

### **User Features**

- 📌 User registration & login (with email verification)
- 🔍 Search and borrow books
- 📅 View borrowed books and due dates
- 🔄 Update user profile information

### **Admin Features**

- 📚 Add, edit, and delete books
- 👥 Manage users (approve/reject new registrations)
- 📊 View all issued books & returns
- 📢 Send notifications for overdue books

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Backend:** PHP, MySQL
- **Database:** MySQL
- **Authentication:** PHP sessions, Email verification with PHPMailer
- **Notifications:** PHPMailer for email alerts

## 📂 Project Structure

```
📂 library-management-system/
├── 📁 screenshot/          # Images
├── 📜 customer.php         # Home page
├── 📜 admin.php            # User login(combined)
├── 📜 admin.php            # User registration
├── 📜 dashboard.php        # User/Admin dashboard
├── 📜 issue_book.php       # Borrow book functionality
├── 📜 return_book.php      # Return book functionality
├── 📜 logout.php           # User logout
└── 📜 README.md            # Project documentation
```

## 🎯 Installation Guide

### **1. Clone the Repository**

```bash
git clone https://github.com/yourusername/library-management-system.git
cd library-management-system
```

### **2. Setup Database**

- Import the `library_db.sql` file into your MySQL database.
- Update `config.php` with your database credentials.

### **3. Install Dependencies**

Ensure you have PHP and MySQL installed. Install PHPMailer via Composer:

```bash
composer require phpmailer/phpmailer
```

### **4. Start the Server**

Use XAMPP, WAMP, or a local PHP server:

```bash
php -S localhost:8000
```

### **5. Access the System**

Open `http://localhost:8000` in your browser.

## 🔧 Configuration

- Edit `config.php` to update database settings.
- Modify `email_config.php` for PHPMailer setup (SMTP credentials).

## 💡 Future Enhancements

- 📌 Implement book reservation system
- 📊 Generate reports for admin analytics
- 📱 Improve UI/UX for mobile responsiveness
- 🛠️ Add search filters and sorting options

## 🤝 Contributing

Feel free to fork, submit issues, or create pull requests.

```bash
git checkout -b feature-branch
```

## 📜 License

This project is open-source under the MIT License.

---

### ✨ Developed By: Franc



