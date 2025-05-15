<?php
// Kết nối đến database
$conn = new mysqli('localhost', 'root', '', 'Webbanbanh');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu phản hồi
$sql = "SELECT name, email, message, created_at FROM contact ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Phản hồi khách hàng</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #fef6f9;
    }
    h1 {
      text-align: center;
      color: #d63384;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background-color: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 15px;
      border: 1px solid #eee;
      text-align: left;
    }
    th {
      background-color: #b47278;
      color: #ffffff;
    }
    tr:hover {
      background-color: #fff0f5;
    }
  </style>
</head>
<body>
  <h1>Danh sách phản hồi khách hàng 📬</h1>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <tr>
        <th>Tên</th>
        <th>Email</th>
        <th>Nội dung</th>
        <th>Thời gian</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row["name"]) ?></td>
          <td><?= htmlspecialchars($row["email"]) ?></td>
          <td><?= nl2br(htmlspecialchars($row["message"])) ?></td>
          <td><?= htmlspecialchars($row["created_at"]) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>Không có phản hồi nào.</p>
  <?php endif; ?>

<?php $conn->close(); ?>
</body>
</html>
