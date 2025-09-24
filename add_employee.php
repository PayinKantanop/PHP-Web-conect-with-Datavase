<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // รับข้อมูลจากฟอร์ม
    $emp_code = $_POST['emp_code'] ?? '';
    $name_th = $_POST['name_th'] ?? '';
    $nickname = $_POST['nickname'] ?? '';

    // ตรวจสอบว่าข้อมูลครบถ้วนหรือไม่
    if(empty($emp_code) || empty($name_th) || empty($nickname)){
        header("Location: index.php?status=incomplete");
        exit();
    }

    // เชื่อมต่อฐานข้อมูล
    $serverName = "ADNB-212000586\SQL2022EXPR";
    $databaseName = "Central";

    try {
        $conn = new PDO("sqlsrv:server=$serverName;Database=$databaseName");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
        $sql = "INSERT INTO dbo.tb_employee (Emp_code, Name_TH, Nickname) VALUES (:emp_code, :name_th, :nickname)";
        $stmt = $conn->prepare($sql);
        
        // ผูกค่าตัวแปรกับพารามิเตอร์
        $stmt->bindParam(':emp_code', $emp_code);
        $stmt->bindParam(':name_th', $name_th);
        $stmt->bindParam(':nickname', $nickname);

        // ดำเนินการเพิ่มข้อมูล
        if($stmt->execute()){
            header("Location: index.php?status=success");
        } else {
            header("Location: index.php?status=error");
        }

    } catch (PDOException $e) {
        // ถ้ามีปัญหา ให้กลับไปที่หน้าเดิมพร้อมข้อความ error
        header("Location: index.php?status=error");
    }

    // ปิดการเชื่อมต่อ
    $conn = null;
} else {
    // ถ้าไม่ใช่ POST ให้กลับไปที่หน้าเดิม
    header("Location: index.php");
    exit();
}
?>