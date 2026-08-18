<?php
session_start();
include("../config/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email) || empty($password)){
        $error = "لطفا همه فیلدها را پر کنید";
    } else {

        try {

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                header("Location: ../dashboard/dashboard.php");
                exit();

            } else {
                $error = "ایمیل یا رمز اشتباه است";
            }

        } catch(PDOException $e){
            $error = "خطای دیتابیس: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8">
<title>ورود به پورتال</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap" rel="stylesheet">

<style>
body {
    direction: rtl;
    font-family: 'Vazirmatn', sans-serif;
    margin: 0;
    height: 100vh;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* کارت */
.card {
    background: #fff;
    padding: 40px 30px;
    width: 360px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    text-align: center;
    animation: fadeIn 0.7s ease;
}

/* انیمیشن */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

.card h2 {
    margin-bottom: 25px;
    color: #2a5298;
}

/* اینپوت */
.input-group {
    position: relative;
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

input:focus {
    border-color: #2a5298;
    box-shadow: 0 0 5px rgba(42,82,152,0.4);
}

/* دکمه */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #2a5298, #1e3c72);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.03);
    background: linear-gradient(135deg, #1e3c72, #2a5298);
}

/* خطا */
.error {
    background: #ffe0e0;
    color: #b30000;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 13px;
}

/* فوتر */
.footer {
    margin-top: 15px;
    font-size: 12px;
    color: #777;
}
</style>
</head>

<body>

<div class="card">

<h2>🏥 ورود به پورتال بیمارستان</h2>

<?php if(!empty($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

    <div class="input-group">
        <input type="email" name="email" placeholder="ایمیل" required>
    </div>

    <div class="input-group">
        <input type="password" name="password" placeholder="رمز عبور" required>
    </div>

    <button name="login">ورود به سیستم</button>

</form>

<div class="footer">
    © سیستم مدیریت بیمارستان
</div>

</div>

</body>
</html>
