<?php
session_start();
include("../config/config.php");

if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}

// گرفتن لیست دکترها
$doctors = $conn->query("SELECT * FROM doctors")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>مدیریت پزشکان</title>

<style>
body{font-family:Vazirmatn; background:#f4f6f9; padding:20px;}
table{
    width:100%;
    background:#fff;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}
a{
    padding:5px 10px;
    text-decoration:none;
    color:white;
    border-radius:5px;
}

.back-btn{
    background: linear-gradient(135deg,#27ae60,#2ecc71);
}
h2{
    margin-bottom:10px;
}

.back-btn{
    display:inline-block;
    margin-bottom:20px;
}

.delete{background:red;}
.edit{background:orange;}
</style>
</head>

<body>


<a href="dashboard.php" class="back-btn">⬅️ بازگشت</a>
<table>
    <tr>
        <th>نام</th>
        <th>تخصص</th>
        <th>شماره</th>
        <th>ایمیل</th>
        <th>عملیات</th>
    </tr>

    <?php foreach($doctors as $doc): ?>
    <tr>
        <td><?= $doc['name'] ?></td>
        <td><?= $doc['specialty'] ?></td>
        <td><?= $doc['phone'] ?></td>
        <td><?= $doc['email'] ?></td>
        <td>
            <a class="edit" href="edit_doctor.php?id=<?= $doc['id'] ?>">ویرایش</a>
            <a class="delete" href="delete_doctor.php?id=<?= $doc['id'] ?>" onclick="return confirm('حذف شود؟')">حذف</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>