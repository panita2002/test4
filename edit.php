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

    // ตรวจสอบว่ามี ID ที่ส่งมาหรือไม่
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // ดึงข้อมูลเอกสารจากฐานข้อมูล
        $stmt = $pdo->prepare("SELECT id, file_name, content FROM documents WHERE id = ?");
        $stmt->execute([$id]);
        $document = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($document) {
            // แสดงแบบฟอร์มแก้ไข
            echo "<h1>Edit Document</h1>";
            echo "<form method='post' action='update.php'>";
            echo "<input type='hidden' name='id' value='{$document['id']}'>";
            echo "<label>File Name:</label><br>";
            echo "<input type='text' name='file_name' value='" . htmlspecialchars($document['file_name']) . "'><br><br>";
            echo "<label>Content:</label><br>";
            echo "<textarea name='content' rows='10' cols='50'>" . htmlspecialchars($document['content']) . "</textarea><br><br>";
            echo "<input type='submit' value='Save Changes'>";
            echo "</form>";
        } else {
            echo "Document not found.";
        }
    } else {
        echo "No document ID specified.";
    }
} catch (Exception $e) {
    // แสดงข้อความข้อผิดพลาด
    echo "Error: " . $e->getMessage();
}
?>
