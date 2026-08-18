<?php
session_start();
include("../config/config.php");

// ثبت نظر
$success = false;

if(isset($_POST['send'])){

    if(!isset($_SESSION['user_id'])){
        die("ابتدا وارد شوید");
    }

    $patient_id = $_SESSION['user_id'];
    $doctor_id = $_POST['doctor_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("
        INSERT INTO reviews (patient_id, doctor_id, comment, rating)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([$patient_id, $doctor_id, $comment, $rating]);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>ثبت نظر</title>

<style>
body{
    font-family:tahoma;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.container{
    background:white;
    padding:30px;
    border-radius:15px;
    width:350px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    text-align:center;
    animation:fadeIn 0.6s;
}

h3{
    margin-bottom:20px;
    color:#2c5364;
}

select, textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-family:tahoma;
}

textarea{
    resize:none;
    height:80px;
}

button{
    width:100%;
    padding:12px;
    background:#2c5364;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    transition:0.3s;
}

button:hover{
    background:#203a43;
}

.success{
    color:green;
    font-weight:bold;
    margin-top:15px;
}

.back{
    margin-top:15px;
    display:inline-block;
    text-decoration:none;
    color:#555;
    font-size:14px;
}

.back:hover{
    color:black;
}

@keyframes fadeIn{
    from{opacity:0;transform:translateY(20px);}
    to{opacity:1;transform:translateY(0);}
}
</style>

</head>

<body>

<div class="container">

<?php if(!$success): ?>

<h3>💬 ثبت نظر</h3>

<form method="POST">

<select name="doctor_id" required>
    <option value="">انتخاب پزشک</option>
    <?php
    $docs = $conn->query("SELECT * FROM doctors");
    foreach($docs as $d){
        echo "<option value='{$d['id']}'>{$d['name']}</option>";
    }
    ?>
</select>

<select name="rating" required>
    <option value="">امتیاز</option>
    <option value="5">⭐⭐⭐⭐⭐ عالی</option>
    <option value="4">⭐⭐⭐⭐ خوب</option>
    <option value="3">⭐⭐⭐ متوسط</option>
    <option value="2">⭐⭐ ضعیف</option>
    <option value="1">⭐ بد</option>
</select>

<textarea name="comment" placeholder="نظر خود را بنویسید..." required></textarea>

<button type="submit" name="send">ثبت نظر</button>

</form>

<?php else: ?>

<h3 class="success">✅ نظر شما با موفقیت ثبت شد</h3>

<a href="../index.php" class="back">⬅ بازگشت به صفحه اصلی</a>

<?php endif; ?>

</div>

</body>
</html>