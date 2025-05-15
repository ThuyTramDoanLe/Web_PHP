<?php
// Kết nối database
$conn = new mysqli('localhost', 'root', '', 'Webbanbanh');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $phonenumber = trim($_POST['phonenumber']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    // Kiểm tra rỗng
    if (empty($fullname) || empty($phonenumber) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "Vui lòng điền đầy đủ tất cả các trường.";
    }

    // Kiểm tra fullname >= 5 kí tự
    if (strlen($fullname) < 5) {
        $errors[] = "Full name phải tối thiểu 5 kí tự.";
    }

    // Kiểm tra phone number đúng 10 số
    if (!preg_match("/^[0-9]{10}$/", $phonenumber)) {
        $errors[] = "Số điện thoại phải đủ 10 số.";
    }

    // Kiểm tra định dạng password (ít nhất 8 kí tự, có chữ hoa, chữ thường, số, ký tự đặc biệt)
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $errors[] = "Password phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt.";
    }

    // Kiểm tra confirm password
    if ($password !== $confirm_password) {
        $errors[] = "Password xác nhận không trùng khớp.";
    }

    // Kiểm tra username đã tồn tại chưa
    $check_username = "SELECT * FROM user WHERE username='$username'";
    $result_username = $conn->query($check_username);
    if ($result_username->num_rows > 0) {
        $errors[] = "Username đã tồn tại.";
    }

    // Kiểm tra email đã tồn tại chưa
    $check_email = "SELECT * FROM user WHERE email='$email'";
    $result_email = $conn->query($check_email);
    if ($result_email->num_rows > 0) {
        $errors[] = "Email đã được đăng ký.";
    }

    if (empty($errors)) {
        // Mã hóa password (optional, an toàn hơn)
        $hashed_password = $password;

        // Thêm user vào database
        $sql = "INSERT INTO user (fullname, phonenumber, email, username, password) 
                VALUES ('$fullname', '$phonenumber', '$email', '$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Đăng ký thành công!'); window.location='sign_in.php';</script>";
        } else {
            echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
        }
    } else {
        // Hiển thị lỗi
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/stylelg.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="sign_up.php" method="post">
            <h1>Sign up </h1>
            <div class="input-box">
                <input type="text" name="fullname" placeholder="Full name" 
                    value="<?php if (!empty($_POST['fullname'])) echo htmlspecialchars($_POST['fullname']); ?>" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="text" name="phonenumber" placeholder="Phone number" required
                    value="<?php if (!empty($_POST['phonenumber'])) echo htmlspecialchars($_POST['phonenumber']); ?>" required>
                <i class='bx bx-phone' ></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required
                    value="<?php if (!empty($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" required>
                <i class='bx bx-envelope'></i>
            </div>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required
                    value="<?php if (!empty($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bx-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <i class='bx bx-lock-alt'></i>
            </div>

            <button class="login-btn" type="submit">Accept</button>
            
            <p>Already have an account? <a href="sign_in.php" class="register">Sign in </a></p>
        </form>
    </div>
</body>
</html>
