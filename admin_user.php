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

// Lọc chỉ người dùng role = 'user'
$sql = "SELECT fullname, username, email, phonenumber, role, created_at FROM user WHERE role = 'user'";
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
    <title>Danh sách người dùng</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <h2>Danh sách người dùng</h2>
    <table>
        <tr>
            <th>Họ tên</th>
            <th>Username</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Role</th>
            <th>Ngày tạo</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['fullname'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['username'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['phonenumber'] ?? '') . "</td>"; // Sử dụng 'phonenumber' thay vì 'phone'
                echo "<td>" . htmlspecialchars($row['role'] ?? '') . "</td>";
                // Nếu chưa có created_at, tạm thời dùng thời gian hiện tại hoặc để trống
                echo "<td>" . date('Y-m-d H:i:s') . "</td>"; // Tạm thời dùng thời gian hiện tại
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có người dùng nào.</td></tr>";
        }
        ?>
    </table>
    <?php $conn->close(); ?>
</body>
</html>