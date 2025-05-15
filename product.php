<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'Webbanbanh');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý tìm kiếm
$search_keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM products";
if (!empty($search_keyword)) {
    $search_keyword = $conn->real_escape_string($search_keyword);
    $sql .= " WHERE name LIKE '%$search_keyword%'";
}

$result = $conn->query($sql);

if ($result === false) {
    echo "<p>Lỗi truy vấn: " . $conn->error . "</p>";
    $products_by_category = [];
} else {
    $products_by_category = [];
    while ($row = $result->fetch_assoc()) {
        $category = $row['category'];
        if (!isset($products_by_category[$category])) {
            $products_by_category[$category] = [];
        }
        $products_by_category[$category][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enti Cake & Dessert</title>
  <link rel="stylesheet" href="css/product.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <nav>
      <div class="logo">
        <img src="image/logo.png" alt="Enti cake Logo"> 
      </div>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="product.php" target="_blank">Product</a></li>
        <li><a href="aboutus.html" target="_blank">About Us</a></li>
        <li><a href="contact.php" target="_blank">Contact</a></li>
      </ul>
      <div class="icons">
        <a href="sign_in.php" class="icon" target="_blank"><i class='bx bx-user'></i></a>
        <a href="cart.html" class="icon" target="_blank"><i class='bx bx-cart'></i></a>
      </div>
    </nav>

    <div class="banner-wrapper">
        <img src="image/home1.jpg" alt="Product Banner" class="product-banner">
    </div>

    <!-- Thanh tìm kiếm -->
    <div class="search-bar">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($search_keyword); ?>">
            <button type="submit"><i class='bx bx-search'></i></button>
        </form>
    </div>

    <?php if (!empty($search_keyword)): ?>
        <h3 style="text-align:center;">Kết quả tìm kiếm cho: <em><?php echo htmlspecialchars($search_keyword); ?></em></h3>
    <?php endif; ?>

    
    
    <?php foreach ($products_by_category as $category => $products): ?>
        <div class="product-title">
            <span class="line"></span>
            <h2><?php echo $category; ?></h2>
            <span class="line"></span>
        </div>

        <section class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php 
                    $img_path = 'image/' . $product['image'];
                    if (strpos($product['image'], 'image/') === 0) {
                        $img_path = $product['image'];
                    }
                    if (file_exists($img_path)) {
                        echo "<img src='$img_path' alt='{$product['name']}'>";
                    } else {
                        echo "<p>Ảnh không tồn tại: $img_path</p>";
                    }
                    ?>
                    <h3><?php echo $product['name']; ?></h3>
                    <p><strong><?php echo number_format($product['price'], 0, ',', '.') . ' đ'; ?></strong></p>
                    <button>Thêm vào giỏ hàng</button>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>
    <br>
    <!-- Thông báo -->
  <!-- Phần icon cố định -->
  <div class="fixed-icons">
    <a href="tel:0983517695" class="icon phone"><i class='bx bxs-phone-call' ></i></a>
    <a href="https://www.instagram.com/nhuqq.26/" class="icon ins" target="_blank"><i class='bx bxl-instagram-alt'></i></a>
    <a href="https://m.me/thu.trangg.2609" class="icon messenger" target="_blank"><i class='bx bxl-messenger'></i></a>
    <a href="https://mail.google.com/mail/u/0/#inbox" class="icon email" target="_blank"><i class='bx bxs-envelope' ></i></a>
    <a href="https://maps.app.goo.gl/EfmnkVuj3Ro8wHw79" class="icon location" target="_blank"><i class='bx bx-location-plus'></i></a>
</div>
    <!-- Phần footer -->
  <footer id="lienhe" class="footer">
    <div class="footer__container">
      <div class="footer__logo-info">
        <a href="#" class="footer__logo-link">
          <img src="image/logo.png" alt="Logo" class="footer__logo">
        </a>
        <div class="footer__contact">
          <p>
            <i class="fas fa-map-marker-alt"><i class='bx bx-map'></i></i>
            43 Đ. Trần Duy Hưng, Trung Hòa, Cầu Giấy, Hà Nội.
          </p>
          <p>
            <i class="fas fa-phone-alt"><i class='bx bx-phone-call' ></i></i>
            0123-456-789         
         </p>
          <p>
            <i class="fas fa-envelope"><i class='bx bx-envelope' ></i></i>
            enticake123@gmail.com
          </p>
        </div>
      </div>
  
      <div class="footer__column">
        <h3 class="footer__heading">DANH MỤC SẢN PHẨM</h3>
        <ul class="footer__list">
          <li><a href="product.php">Cake</a></li>
          <li><a href="product.php">Tiramisu</a></li>
          <li><a href="product.php">Mousse</a></li>
          <li><a href="product.php">Donut</a></li>
        </ul>
      </div>
  
      <div class="footer__column">
        <h3 class="footer__heading">HỖ TRỢ KHÁCH HÀNG</h3>
        <ul class="footer__list">
          <li><a href="#">Tìm kiếm</a></li>
          <li><a href="#">Điều khoản dịch vụ</a></li>
          <li><a href="#">Chính sách bảo mật</a></li>
          <li><a href="#">Chính sách thanh toán</a></li>
          <li><a href="#">Chính sách giao hàng</a></li>
          <li><a href="#">Chính sách đổi trả</a></li>
          <li><a href="#">Hướng dẫn mua hàng online</a></li>
          <li><a href="#">Chính sách xuất Hóa đơn GTGT</a></li>
        </ul>
      </div>
  
      <div class="footer__column">
        <h3 class="footer__heading">VỀ CHÚNG TÔI</h3>
        <ul class="footer__list">
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="product.php">Sản phẩm</a></li>
          <li><a href="aboutus.html">Giới thiệu</a></li>
          <li><a href="contact.php">Liên hệ</a></li>
        </ul>
      </div>
    </div>
  
    <div class="footer__bottom">
      <p>© 2025 Welcome to Enti Cake & Dessert.</p>
    </div>
  </footer>
</body>
</html>
