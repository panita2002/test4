<?php
require_once('fpdf.php');
require_once('fpdi/autoload.php');

use setasign\Fpdi\Fpdi;

// สร้างออบเจ็กต์ FPDI
$pdf = new Fpdi();

// เพิ่มหน้าต่างใหม่
$pdf->AddPage();

// เลือกไฟล์ PDF ที่ต้องการดึงข้อมูล
$pdf->setSourceFile('document.pdf');

// เลือกหน้าแรก
$template = $pdf->importPage(1);

// ใช้เทมเพลตในหน้าปัจจุบัน
$pdf->useTemplate($template);

// แสดงไฟล์ PDF
$pdf->Output();
?>