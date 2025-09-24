<?php
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $feedback_message = "เพิ่มข้อมูลพนักงานสำเร็จ!";
            $feedback_type = 'success';
            break;
        case 'error':
            $feedback_message = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
            $feedback_type = 'error';
            break;
        case 'incomplete':
            $feedback_message = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
            $feedback_type = 'error';
            break;
    }
}


$serverName = "ADNB-212000586\SQL2022EXPR";
$databaseName = "Central";
$pageTitle = "ข้อมูลพนักงาน"; // เตรียมข้อมูลสำหรับแสดงผล
$results = []; // สร้างตัวแปรเปล่าไว้ก่อน
$error_message = null;

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT Emp_code, Name_TH, Nickname FROM dbo.tb_employee";
    $stmt = $conn->query($sql);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // ถ้ามีปัญหา ให้เก็บข้อความ error ไว้ในตัวแปร
    $error_message = "การเชื่อมต่อหรือการดึงข้อมูลล้มเหลว: " . $e->getMessage();
}

$conn = null;

// 2. เรียกไฟล์ View เพื่อนำข้อมูลไปแสดงผล
// ไฟล์ Logic จะไม่ echo HTML เอง แต่จะส่งต่อให้ไฟล์ View จัดการ
require 'employee_view.php';
?>
