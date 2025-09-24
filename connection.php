<?php
// กำหนดแค่ชื่อ Server และ Database
$serverName = "ADNB-212000586\SQL2022EXPR";
$databaseName = "Central";

try {
    // สร้างการเชื่อมต่อ PDO
    $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName");
    
    // ตั้งค่า error mode เป็น exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "เชื่อมต่อสำเร็จ! 👍<br/>";

} catch (PDOException $e) { // 1. ย้าย catch มาไว้ต่อจาก try ที่ถูกต้อง
    echo "การเชื่อมต่อหรือการดึงข้อมูลล้มเหลว: " . $e->getMessage();
}
// ปิดการเชื่อมต่อ
$conn = null;
?>             