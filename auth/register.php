<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8">
<title>ثبت‌نام</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">

<style>
body {
    direction: rtl;
    font-family: 'Vazirmatn', sans-serif;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    margin: 0;
}

/* کانتینر وسط */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* کارت */
.card {
    background: #fff;
    padding: 30px;
    width: 350px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    text-align: center;
}

/* عنوان */
.card h2 {
    margin-bottom: 20px;
    color: #333;
}

/* اینپوت‌ها */
input, select {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    transition: 0.3s;
}

input:focus, select:focus {
    border-color: #4facfe;
    box-shadow: 0 0 5px #4facfe;
}

/* دکمه */
button {
    width: 100%;
    padding: 12px;
    background: #4facfe;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #2b8df7;
}

/* پیام */
.success {
    color: green;
}
.error {
    color: red;
}

</style>
</head>

<body>

<div class="container">
<div class="card">

<?php
include("../config/config.php");

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (fullname,email,password,role)
            VALUES ('$fullname','$email','$password','$role')";

    if($conn->query($sql)){
        echo "<p class='success'>ثبت‌نام موفق 🎉</p>";
    }else{
        echo "<p class='error'>خطا: " . $conn->error . "</p>";
    }
}
?>

<h2>ثبت‌نام در پورتال</h2>

<form method="POST">
    <input type="text" name="fullname" placeholder="نام و نام خانوادگی" required>
    <input type="email" name="email" placeholder="ایمیل" required>
    <input type="password" name="password" placeholder="رمز عبور" required>

    <select name="role">
        <option value="patient">بیمار</option>
        <option value="doctor">پزشک</option>
    </select>

    <button name="register">ثبت‌نام</button>
</form>

</div>
</div>

</body>
</html>