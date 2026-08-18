<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8">
<title>پورتال بیمارستان</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">

<style>
body {
    direction: rtl;
    font-family: 'Vazirmatn', sans-serif;
    margin: 0;
    background: #f5f7fa;
}

/* هدر */
.header {
    background: #2c7be5;
    color: white;
    padding: 15px;
    text-align: center;
}

/* منو */
.nav {
    background: #fff;
    display: flex;
    justify-content: space-around;
    padding: 10px;
    box-shadow: 0 2px 5px #ccc;
}

.nav a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

/* کارت‌ها */
.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap: 20px;
    padding: 20px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 10px #ddd;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* دکمه */
button {
    background: #2c7be5;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #1a5fd0;
}
</style>
</head>

<body>

<div class="header">
    <h2>🏥 پورتال بیمارستان</h2>
</div>

<div class="nav">
    <a href="#">خانه</a>
    <a href="#">پزشکان</a>
    <a href="#">نوبت‌دهی</a>
    <a href="#">آزمایش‌ها</a>
    <a href="#">تماس با ما</a>
</div>

<div class="container">

    <div class="card">
        <h3>🧴 مراقبت پوست</h3>
        <p>مشاهده خدمات پوست و زیبایی</p>
        <button>مشاهده</button>
    </div>

    <div class="card">
        <h3>💬 نظرات بیماران</h3>
        <p>کامنت و تجربه بیماران</p>
        <button>مشاهده</button>
    </div>

    <div class="card">
        <h3>🖼️ گالری تصاویر</h3>
        <p>تصاویر قبل و بعد درمان</p>
        <button>مشاهده</button>
    </div>

    <div class="card">
        <h3>📅 نوبت‌دهی</h3>
        <p>رزرو نوبت آنلاین</p>
        <button>رزرو</button>
    </div>

</div>

</body>
</html>