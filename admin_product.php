<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: sign_in.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'Webbanbanh');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $conn->real_escape_string($_POST['category']);
    $image = $conn->real_escape_string($_POST['image']);

    $sql = "INSERT INTO products (name, description, price, stock, category, image) VALUES ('$name', '$description', $price, $stock, '$category', '$image')";
    if ($conn->query($sql) === TRUE) {
        $message = "Thêm sản phẩm thành công!";
    } else {
        $message = "Lỗi: " . $conn->error;
    }
}

// Xử lý sửa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $conn->real_escape_string($_POST['category']);
    $image = $conn->real_escape_string($_POST['image']);

    $sql = "UPDATE products SET name='$name', description='$description', price=$price, stock=$stock, category='$category', image='$image' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Cập nhật sản phẩm thành công!";
    } else {
        $message = "Lỗi: " . $conn->error;
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM products WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        $message = "Xóa sản phẩm thành công!";
    } else {
        $message = "Lỗi: " . $conn->error;
    }
}

// Lấy sản phẩm để chỉnh sửa (nếu có)
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$edit_product = null;
if ($edit_id > 0) {
    $sql = "SELECT * FROM products WHERE id = $edit_id";
    $result_edit = $conn->query($sql);
    if ($result_edit && $result_edit->num_rows > 0) {
        $edit_product = $result_edit->fetch_assoc();
    }
}

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #b47278;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .form-container {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            margin: 5px 0;
            padding: 8px;
        }
        .form-container button {
            background-color: #b47278;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            color: #fff;
            background-color: #4CAF50;
            display: inline-block;
        }
        .error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h2>Quản lý sản phẩm</h2>
    <?php if (isset($message)) echo "<div class='message " . (strpos($message, 'Lỗi') !== false ? 'error' : '') . "'>$message</div>"; ?>

    <!-- Form chỉnh sửa sản phẩm -->
    <div class="form-container" style="display: <?php echo $edit_product ? 'block' : 'none'; ?>">
        <h3>Chỉnh sửa sản phẩm</h3>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $edit_product['id'] ?? ''; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($edit_product['name'] ?? ''); ?>" required><br>
            <textarea name="description" required><?php echo htmlspecialchars($edit_product['description'] ?? ''); ?></textarea><br>
            <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($edit_product['price'] ?? ''); ?>" required><br>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($edit_product['stock'] ?? ''); ?>" required><br>
            <select name="category" required>
                <option value="Cake" <?php echo ($edit_product['category'] ?? '') == 'Cake' ? 'selected' : ''; ?>>Cake</option>
                <option value="Tiramisu" <?php echo ($edit_product['category'] ?? '') == 'Tiramisu' ? 'selected' : ''; ?>>Tiramisu</option>
                <option value="Mousse" <?php echo ($edit_product['category'] ?? '') == 'Mousse' ? 'selected' : ''; ?>>Mousse</option>
                <option value="Donut" <?php echo ($edit_product['category'] ?? '') == 'Donut' ? 'selected' : ''; ?>>Donut</option>
            </select><br>
            <input type="text" name="image" value="<?php echo htmlspecialchars($edit_product['image'] ?? ''); ?>" placeholder="Đường dẫn ảnh (VD: image/cake1.jpg)"><br>
            <button type="submit" name="edit_product">Cập nhật</button>
        </form>
    </div>

    <!-- Form thêm sản phẩm -->
    <div class="form-container">
        <h3>Thêm sản phẩm mới</h3>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Tên sản phẩm" required><br>
            <textarea name="description" placeholder="Mô tả sản phẩm" required></textarea><br>
            <input type="number" name="price" step="0.01" placeholder="Giá" required><br>
            <input type="number" name="stock" placeholder="Số lượng tồn kho" required><br>
            <select name="category" required>
                <option value="Cake">Cake</option>
                <option value="Tiramisu">Tiramisu</option>
                <option value="Mousse">Mousse</option>
                <option value="Donut">Donut</option>
            </select><br>
            <input type="text" name="image" placeholder="Đường dẫn ảnh (VD: image/cake1.jpg)"><br>
            <button type="submit" name="add_product">Thêm sản phẩm</button>
        </form>
    </div>

    <!-- Bảng danh sách sản phẩm -->
    <table>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Danh mục</th>
            <th>Ảnh</th>
            <th>Ngày tạo</th>
            <th>Ngày cập nhật</th>
            <th>Hành động</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . number_format($row['price'], 2) . " VNĐ</td>";
                echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['image'] ?? 'Chưa có ảnh') . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
                echo "<td><a href='?edit_id=" . $row['id'] . "'>Sửa</a> | <a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Bạn có chắc muốn xóa?\");'>Xóa</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Không có sản phẩm nào.</td></tr>";
        }
        ?>
    </table>
    <?php $conn->close(); ?>
</body>
</html>