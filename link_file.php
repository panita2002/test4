<?php
// กำหนดเส้นทางของไฟล์ HTML
$file = 'document.html';

// ตรวจสอบว่าไฟล์มีอยู่หรือไม่
if (file_exists($file)) {
    // อ่านและแสดงข้อมูลจากไฟล์ HTML
    include($file);
} else {
    echo "File not found.";
}
?>
