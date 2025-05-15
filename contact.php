<?php
// Biến hiển thị thông báo
$feedbackMessage = "";

// Nếu người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kết nối database
    $conn = new mysqli('localhost', 'root', '', 'Webbanbanh');
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Lấy và lọc dữ liệu
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedbackMessage = "<p style='color: red;'>Email không hợp lệ!</p>";
    } else {
        // Thêm vào CSDL
        $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $feedbackMessage = "<p style='color: green;'>Cảm ơn bạn đã gửi phản hồi!</p>";
        } else {
            $feedbackMessage = "<p style='color: red;'>Lỗi khi gửi phản hồi: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact</title>
  <link rel="stylesheet" href="css/contact.css" />
</head>
<body>
<header>
  <nav>
    <div class="logo">
      <img src="image/logo.png" alt="Enti cake Logo"> 
    </div>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="product.php" target="_blank">Product</a></li>
      <li><a href="aboutus.html" target="_blank">About Us</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="icons">
      <a href="sign_in.php" class="icon" target="_blank"><i class='bx bx-user'></i></a>
      <a href="#" class="icon" target="_blank"><i class='bx bx-cart'></i></a>
    </div>
  </nav>
</header>

<div class="contact-container">
  <h1>Liên hệ với chúng tôi 🍰</h1>

  <div class="info">
    <p><strong>📞 Phone Number:</strong> 0123 456 789</p>
    <p><strong>📧 Email:</strong> Enti123@gmail.com</p>
    <p><strong>🏠 Address:</strong> 43 Trần Duy Hưng, Trung Hòa, Cầu Giấy, Hà Nội</p>
  </div>

  <!-- Hiển thị thông báo phản hồi -->
  <?php echo $feedbackMessage; ?>

  <form class="contact-form" action="contact.php" method="post">
    <h2>Gửi lời nhắn cho chúng tôi</h2>
    <input type="text" name="name" placeholder="Tên của bạn" required />
    <input type="email" name="email" placeholder="Email của bạn" required />
    <textarea name="message" placeholder="Lời nhắn..." rows="5" required></textarea>
    <button type="submit">Gửi 📨</button>
  </form>
</div>
</body>
</html>
