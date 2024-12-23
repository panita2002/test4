<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = 'localhost';
$dbname = 'test4'; // แก้ไขชื่อฐานข้อมูลตามจริง
$username = 'root';
$password = '';

try {
    // เชื่อมต่อฐานข้อมูล
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงข้อมูลจากฐานข้อมูล
    $stmt = $pdo->query("SELECT id, file_name, uploaded_at FROM documents");
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // แสดงข้อมูลในรูปแบบ HTML
    echo "<h1>Uploaded Files</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>File Name</th><th>Uploaded At</th><th>Actions</th></tr>";
    foreach ($documents as $doc) {
        echo "<tr>";
        echo "<td>{$doc['id']}</td>";
        echo "<td>{$doc['file_name']}</td>";
        echo "<td>{$doc['uploaded_at']}</td>";
        echo "<td><a href='edit.php?id={$doc['id']}'>Edit</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    // แสดงข้อความข้อผิดพลาด
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage DOCX Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            color: #5a5a5a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Manage DOCX Files</h1>
    <a href="Search.php">Search</a>
    <!-- ส่วนของเนื้อหา -->
    <div class="container mt-5">
        <h1 class="text-center text-primary">Manage DOCX Files</h1>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>File Name</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop เพื่อแสดงข้อมูล -->
                <?php foreach ($documents as $doc): ?>
                    <tr>
                        <td><?= $doc['id'] ?></td>
                        <td><?= htmlspecialchars($doc['file_name']) ?></td>
                        <td><?= $doc['uploaded_at'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="upload.php" class="btn btn-success">Upload New File</a>
    </div>
</body>
</html>
