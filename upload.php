<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;

// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = 'localhost';
$dbname = 'test4';
$username = 'root';
$password = '';

// เชื่อมต่อฐานข้อมูล
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['docx_file'])) {
        $file = $_FILES['docx_file'];

        // ตรวจสอบว่ามีการอัปโหลดไฟล์
        if ($file['error'] === UPLOAD_ERR_OK) {
            $filePath = $file['tmp_name'];
            $fileName = $file['name'];

            // โหลดไฟล์ .docx
            $phpWord = IOFactory::load($filePath);

            // ดึงเนื้อหาจากไฟล์
            $text = "";
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if ($element instanceof PhpOffice\PhpWord\Element\Text) {
                        $text .= $element->getText() . "\n";
                    } elseif ($element instanceof PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $subElement) {
                            if ($subElement instanceof PhpOffice\PhpWord\Element\Text) {
                                $text .= $subElement->getText() . "\n";
                            }
                        }
                    }
                }
            }

            // บันทึกข้อมูลลงฐานข้อมูล
            $stmt = $pdo->prepare("INSERT INTO documents (file_name, content) VALUES (:file_name, :content)");
            $stmt->execute([
                'file_name' => $fileName,
                'content' => $text,
            ]);

            echo "อัปโหลดและบันทึกข้อมูลสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload DOCX</title>
</head>
<body>
    <h1>Upload DOCX File</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="docx_file" accept=".docx" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
