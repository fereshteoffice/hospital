<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

// اطلاعات کاربر
$name = $_SESSION['name'] ?? 'کاربر';
$role = $_SESSION['role'] ?? 'نامشخص';

// آمار
$doctors = $conn->query("SELECT COUNT(*) as total FROM doctors")->fetch(PDO::FETCH_ASSOC);
$patients = $conn->query("SELECT COUNT(*) as total FROM patients")->fetch(PDO::FETCH_ASSOC);
$appointments = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch(PDO::FETCH_ASSOC);
$reviews = $conn->query("SELECT COUNT(*) as total FROM reviews")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>داشبورد بیمارستان</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Vazirmatn';
    display:flex;
    background:#f4f6f9;
}

.sidebar{
    width:220px;
    background:#2c3e50;
    color:#fff;
    height:100vh;
    padding:20px;
}

.sidebar a{
    display:block;
    color:#fff;
    text-decoration:none;
    margin:15px 0;
}

.sidebar a:hover{
    background:#34495e;
    padding:5px;
    border-radius:5px;
}

.main{ flex:1; }

.header{
    background:#fff;
    padding:15px;
    display:flex;
    justify-content:space-between;
    box-shadow:0 2px 5px #ccc;
}

.container{
    padding:20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
}

.card{
    background: linear-gradient(135deg,#3498db,#6dd5fa);
    color:white;
    padding:20px;
    border-radius:12px;
    text-align:center;
}
</style>
</head>

<body>

<div class="sidebar">
    <h3>🏥 بیمارستان</h3>

    <a href="../index.php">🏠 وبلاگ</a>
    <a href="add_doctor.php">➕ افزودن دکتر</a>
    <a href="manage_doctors.php">👨‍⚕️ مدیریت پزشکان</a>
    <a href="appointments.php">📅 نوبت‌ها</a>
    <a href="patient.php">📋 بیماران</a>
    <a href="reviews.php">💬 مدیریت نظرات</a>
</div>

<div class="main">

<div class="header">
    <div>خوش آمدی <?php echo htmlspecialchars($name); ?> 👋</div>
    <div>
        نقش: <?php echo htmlspecialchars($role); ?> |
        <a href="../auth/logout.php">خروج</a>
    </div>
</div>

<div class="container">

<div class="card">
    <h3>👨‍⚕️ پزشکان</h3>
    <p><?php echo $doctors['total']; ?></p>
</div>

<div class="card">
    <h3>📅 نوبت‌ها</h3>
    <p><?php echo $appointments['total']; ?></p>
</div>

<div class="card">
    <h3>📋 بیماران</h3>
    <p><?php echo $patients['total']; ?></p>
</div>

<div class="card">
    <h3>💬 نظرات</h3>
    <p><?php echo $reviews['total']; ?></p>
</div>

</div>
</div>
</body>
</html>