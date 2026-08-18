<?php
include("../config/config.php");

$id = $_GET['id'] ?? null;
if(!$id) die("خطا");

$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->execute([$id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$doctor) die("دکتری پیدا نشد");

if(isset($_POST['update'])){
    $stmt = $conn->prepare("
        UPDATE doctors 
        SET name=?, specialty=?, phone=?, email=? 
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['name'],
        $_POST['specialty'],
        $_POST['phone'],
        $_POST['email'],
        $id
    ]);

    header("Location: manage_doctors.php");
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>ویرایش پزشک</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Vazirmatn';
    background: linear-gradient(135deg,#e3f2fd,#ffffff);
    margin:0;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* کارت */
.card{
    background:#fff;
    padding:30px;
    width:400px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

/* عنوان */
h2{
    text-align:center;
    margin-bottom:20px;
    color:#2c3e50;
}

/* فرم */
label{
    display:block;
    margin-top:10px;
    margin-bottom:5px;
    font-weight:bold;
    color:#555;
}

input{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#3498db;
    box-shadow:0 0 5px #3498db44;
}

/* دکمه */
button{
    width:100%;
    margin-top:20px;
    padding:12px;
    border:none;
    border-radius:10px;
    background: linear-gradient(135deg,#3498db,#6dd5fa);
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
}

/* لینک برگشت */
.back{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#888;
}
.back:hover{
    color:#000;
}
</style>

</head>

<body>

<div class="card">
    <h2>👨‍⚕️ ویرایش پزشک</h2>

    <form method="POST">
        <label>نام پزشک</label>
        <input type="text" name="name" value="<?= $doctor['name'] ?>" required>

        <label>تخصص</label>
        <input type="text" name="specialty" value="<?= $doctor['specialty'] ?>" required>

        <label>شماره تماس</label>
        <input type="text" name="phone" value="<?= $doctor['phone'] ?>">

        <label>ایمیل</label>
        <input type="email" name="email" value="<?= $doctor['email'] ?>">

        <button name="update">💾 ذخیره تغییرات</button>
    </form>

    <a class="back" href="manage_doctors.php">⬅️ بازگشت</a>
</div>

</body>
</html>