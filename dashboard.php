<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: sign_in.php');
    exit();
}

// Đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: sign_in.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            background-color: #f0f2f5;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #b47278;
            color: white;
            position: fixed;
            height: 100vh;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
        }
        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-section img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            margin-bottom: 30px;
        }
        .profile-section p {
            font-size: 20px;
            color: #ecf0f1;
            margin: 0;
        }
        .menu-items a {
            color: #ecf0f1;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 20px 25px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .menu-items a i {
            margin-right: 10px;
            font-size: 14px;
        }
        .menu-items a:hover {
            background-color: #666;
            color: #fff;
        }
        .logout a {
            color: #ecf0f1;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin-top: 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .logout a i {
            margin-right: 10px;
            font-size: 14px;
        }
        .logout a:hover {
            background-color: #666;
            color: #fff;
        }
        .main {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .card h3 {
            margin-top: 0;
            color: #333;
        }
        .card p, .card ul {
            color: #666;
        }
        .card ul li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile-section">
            <img src="image/admin.webp" alt="Admin Avatar">
            <p>Hello, Admin</p>
        </div>
        <div class="menu-items">
            <a href="admin_user.php" target="_blank"><i class="fa-solid fa-user"></i>Customers</a>
            <a href="admin_product.php" target="_blank"><i class="fa-solid fa-box"></i>Category</a>
            <a href="admin_contact.php" target="_blank"><i class="fa-solid fa-id-card"></i> Contact</a>
        </div>
        <div class="logout">
            <a href="?logout=true"><i class="fa-solid fa-right-from-bracket"></i>Log out</a>
        </div>
    </div>

    <div class="main">
        <div class="card">
            <h2>Welcome, Admin! 🌟</h2>
            <p>Start your day by managing your system with ease!</p>
        </div>

        <div class="card">
            <h3>Overview </h3>
            <ul>
                <li>👥 Users: 120</li>
                <li>📦 Products: 48</li>
                <li>📝 Orders Today: 15</li>
            </ul>
        </div>

        <div class="card">
            <h3>Enti Cake & Dessert</h3>
            
        </div>
    </div>
</body>
</html>