<?php
// Bắt đầu session
session_start();

// Kiểm tra xem user đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển về trang đăng nhập
    header('Location: sign_in.php');
    exit;
}

// Nếu đã đăng nhập, hiển thị thông tin
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trang cá nhân</title>
    <style>
        body { 
            font-family: Arial; 
            background-color: #f8f8f8; 
            text-align: center; 
            padding-top: 100px;
        }
        .profile-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #ff6666;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="profile-box">
        <h1>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Chào mừng bạn đến với tiệm b của chúng mình ❤️</p>
        <a href="sign_in.php">Đăng xuất</a>
    </div>
</body>
</html>
