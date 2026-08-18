<?php
session_start();
include("../config/config.php");

// فقط مدیر اجازه داشته باشد
if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>افزودن دکتر</title>

<!-- فونت -->
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Vazirmatn', sans-serif;
}

body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* کارت فرم */
.container{
    background:#fff;
    padding:30px;
    border-radius:15px;
    width:420px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    animation:fadeIn 0.6s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

/* ورودی‌ها */
.input-group{
    margin-bottom:15px;
}

input{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    transition:0.3s;
    font-size:14px;
}

input:focus{
    border-color:#667eea;
    outline:none;
    box-shadow:0 0 5px rgba(102,126,234,0.5);
}

/* دکمه */
button{
    width:100%;
    padding:12px;
    background: linear-gradient(135deg,#27ae60,#2ecc71);
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.03);
    opacity:0.9;
}

/* دکمه بازگشت */
.back{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#666;
    transition:0.3s;
}

.back:hover{
    color:#000;
}
</style>
</head>

<body>

<div class="container">
    <h2>➕ افزودن دکتر جدید</h2>

    <form method="POST" action="save_doctor.php">

        <div class="input-group">
            <input type="text" name="name" placeholder="نام دکتر" required>
        </div>

        <div class="input-group">
            <input type="text" name="specialty" placeholder="تخصص" required>
        </div>

        <div class="input-group">
            <input type="text" name="phone" placeholder="شماره تماس">
        </div>

        <div class="input-group">
            <input type="email" name="email" placeholder="ایمیل">
        </div>

        <button type="submit">💾 ذخیره اطلاعات</button>

    </form>

    <a href="dashboard.php" class="back">⬅️ بازگشت به داشبورد</a>
</div>

</body>
</html>