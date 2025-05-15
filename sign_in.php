<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'Webbanbanh');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$thongbao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // So sánh mật khẩu (nếu bé chưa dùng password_hash thì vẫn dùng == tạm thời)
        if ($password == $row['password']) {
        // Nếu bé dùng password_hash khi đăng ký thì đổi dòng trên thành:
        // if (password_verify($password, $row['password'])) {

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role']; // lưu vai trò

            if ($row['role'] == 'admin') {
                echo "<script>alert('Đăng nhập thành công với quyền admin'); window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('Đăng nhập thành công'); window.location='profile.php';</script>";
            }

        } else {
            $thongbao = "Sai mật khẩu!";
        }
    } else {
        $thongbao = "Username không tồn tại!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="css/stylelg.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="sign_in.php" method="POST">
            <h1>Sign in</h1>

            <?php if ($thongbao != "") echo "<p style='color:red; text-align:center;'>$thongbao</p>"; ?>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bx-user' ></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bx-lock-alt'></i>
            </div>
            <div class="options">
                <label><input type="checkbox"> Remember me</label>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            
            <button class="login-btn">Sign in</button>
            
            <p>Don't have an account? <a href="sign_up.php" class="register">Sign up </a></p>
            
        </form>
    </div>
</body>
</html>
