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
