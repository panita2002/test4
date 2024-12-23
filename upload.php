<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

$host = 'localhost';
$dbname = 'test4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        $file = $_FILES['file'];
        
        // ตรวจสอบว่าไฟล์ถูกอัปโหลด
        if ($file['error'] === UPLOAD_ERR_OK) {
            $filePath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // ตรวจสอบประเภทของไฟล์
            if ($fileType == 'docx' || $fileType == 'doc') {
                // สำหรับไฟล์ DOC และ DOCX ใช้ PhpWord
                $phpWord = IOFactory::load($filePath);
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
            } elseif ($fileType == 'pdf') {
                // สำหรับไฟล์ PDF ใช้ PDFParser
                $parser = new Parser();
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText(); // ดึงข้อความจากไฟล์ PDF
            } else {
                echo "ไฟล์ไม่รองรับประเภทนี้";
                exit;
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
    <title>Upload File</title>
</head>
<body>
    <h1>Upload DOC, DOCX, PDF File</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept=".pdf,.docx,.doc" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
