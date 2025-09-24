<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* --- Theme หลัก: Dark Mode + Cyberpunk --- */
        :root {
            --bg-color: #0f0f18; /* สีกรมท่าเข้มเกือบดำ */
            --glass-bg: rgba(26, 26, 46, 0.5); /* สีของแผ่นแก้ว โปร่งแสง */
            --border-color: rgba(122, 122, 255, 0.2); /* สีขอบแก้ว */
            --primary-text: #e0e0e0; /* สีตัวอักษรทั่วไป */
            --glow-color: #00f5c3; /* สีเขียวมิ้นท์ Neon สำหรับเรืองแสง */
            --glow-gradient: linear-gradient(90deg, #6c5dff, #b35dff); /* สี Gradient สำหรับหัวข้อ */
        }

        body {
            background-color: var(--bg-color);
            color: var(--primary-text);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 25px 25px;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        /* --- สไตล์หัวข้อหลักให้เป็น Gradient --- */
        h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            background: var(--glow-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
        }

        /* --- เอฟเฟกต์แก้ว (Glassmorphism) สำหรับตาราง --- */
        .table-glass {
            background: var(--glass-bg);
            border-radius: 15px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            overflow-x: auto; /* ทำให้ตารางเลื่อนแนวนอนได้บนมือถือ */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* --- Font แบบ Code สำหรับข้อมูล --- */
        th, td {
            padding: 1rem;
            text-align: left;
            font-family: 'JetBrains Mono', monospace;
        }

        /* --- ทำให้หัวตารางเรืองแสง (Glow Effect) --- */
        thead th {
            color: var(--glow-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--border-color);
            text-shadow: 0 0 5px var(--glow-color);
        }

        /* --- สไตล์ของแถวข้อมูล --- */
        tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s ease;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: rgba(108, 93, 255, 0.1);
        }

        /* --- สไตล์สำหรับแสดงข้อความ Error หรือ ไม่มีข้อมูล --- */
        .message {
            text-align: center;
            padding: 2rem;
            font-size: 1.2rem;
            font-family: 'JetBrains Mono', monospace;
            color: var(--glow-color);
        }
        .form-glass {
            background: var(--glass-bg);
            border-radius: 15px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            align-items: flex-end;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-family: 'Poppins', sans-serif;
            color: var(--glow-color);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            background-color: rgba(0,0,0,0.2);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.8rem 1rem;
            color: var(--primary-text);
            font-family: 'JetBrains Mono', monospace;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--glow-color);
            box-shadow: 0 0 10px var(--glow-color);
        }
        .submit-btn {
            background: var(--glow-gradient);
            border: none;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease;
            height: 48px; /* ทำให้ความสูงเท่า input */
        }
        .submit-btn:hover {
            transform: scale(1.05);
        }

        /* --- (ส่วนที่เพิ่มเข้ามา) สไตล์สำหรับข้อความ Feedback --- */
        .feedback {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
        }
        .feedback.success {
            background-color: rgba(0, 245, 195, 0.2);
            color: var(--glow-color);
            border: 1px solid var(--glow-color);
        }
        .feedback.error {
            background-color: rgba(255, 70, 100, 0.2);
            color: #ff4664;
            border: 1px solid #ff4664;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Data Core</h1>

        <?php if ($feedback_message): ?>
            <div class="feedback <?= htmlspecialchars($feedback_type) ?>">
                <?= htmlspecialchars($feedback_message) ?>
            </div>
        <?php endif; ?>

        <div class="form-glass">
            <form action="add_employee.php" method="POST" class="form-grid">
                <div class="form-group">
                    <label for="emp_code">Employee ID</label>
                    <input type="text" id="emp_code" name="emp_code" required>
                </div>
                <div class="form-group">
                    <label for="name_th">Name</label>
                    <input type="text" id="name_th" name="name_th" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" id="nickname" name="nickname" required>
                </div>
                <button type="submit" class="submit-btn">Add Employee</button>
            </form>
        </div>

        <div class="table-glass">
             </div>
    </div>
</body>
</html>