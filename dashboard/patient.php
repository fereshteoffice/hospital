<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

/* =========================
   ADD PATIENT
========================= */
if(isset($_POST['add_patient'])){

    $stmt = $conn->prepare("
        INSERT INTO patients 
        (user_id, name, last_name, age, gender, phone, insurance_type, disease_type)
        VALUES (?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['name'],
        $_POST['last_name'],
        $_POST['age'],
        $_POST['gender'],
        $_POST['phone'],
        $_POST['insurance_type'],
        $_POST['disease_type']
    ]);
}

/* =========================
   UPDATE PATIENT
========================= */
if(isset($_POST['update_patient'])){

    $stmt = $conn->prepare("
        UPDATE patients SET 
        name=?, last_name=?, age=?, gender=?, phone=?, insurance_type=?, disease_type=?
        WHERE id=?
    ");

    $stmt->execute([
        $_POST['name'],
        $_POST['last_name'],
        $_POST['age'],
        $_POST['gender'],
        $_POST['phone'],
        $_POST['insurance_type'],
        $_POST['disease_type'],
        $_POST['patient_id']
    ]);
}

/* =========================
   GET PATIENTS
========================= */
$patients = $conn->query("SELECT * FROM patients ORDER BY id DESC")->fetchAll();

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>سیستم بیمارستان</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Vazirmatn';
    direction:rtl;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

.container{
    width:1100px;
    margin:30px auto;
}

.card{
    background: rgba(255,255,255,0.95);
    padding:20px;
    margin-top:20px;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

input, select{
    width:100%;
    padding:10px;
    margin:6px 0;
    border-radius:10px;
    border:1px solid #ddd;
}

button{
    background: linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    border:none;
    padding:10px;
    border-radius:10px;
    cursor:pointer;
}

table{
    width:100%;
    margin-top:10px;
    border-collapse:collapse;
}

th{
    background:#667eea;
    color:white;
    padding:10px;
}

td{
    text-align:center;
    padding:10px;
}

.group-warning{
    background:#fff3cd;
}

.badge{
    padding:4px 10px;
    border-radius:8px;
    background:#ff9800;
    color:white;
    font-size:12px;
}
</style>

</head>

<body>

<div class="container">

<!-- ================= ADD PATIENT ================= -->
<div class="card">
<h3>➕ افزودن بیمار</h3>

<form method="POST">

<input type="text" name="name" placeholder="نام">
<input type="text" name="last_name" placeholder="نام خانوادگی">
<input type="number" name="age" placeholder="سن">

<select name="gender">
    <option value="male">مرد</option>
    <option value="female">زن</option>
</select>

<input type="text" name="phone" placeholder="شماره">

<input type="text" name="insurance_type" placeholder="نوع بیمه">
<input type="text" name="disease_type" placeholder="نوع بیماری">

<button name="add_patient">ثبت</button>

</form>
</div>

<!-- ================= PATIENT LIST ================= -->
<div class="card">
<h3>👥 بیماران + نوبت‌ها</h3>

<table>
<tr>
<th>نام</th>
<th>سن</th>
<th>شماره</th>
<th>بیمه</th>
<th>نوبت‌ها</th>
</tr>

<?php foreach($patients as $p): ?>

<tr>

<td><?= $p['name'] ?> <?= $p['last_name'] ?></td>
<td><?= $p['age'] ?></td>
<td><?= $p['phone'] ?></td>
<td><?= $p['insurance_type'] ?></td>

<td>

<?php
$stmt = $conn->prepare("
SELECT a.*, d.name as doctor_name
FROM appointments a
JOIN doctors d ON d.id = a.doctor_id
WHERE a.patient_id=?
ORDER BY a.visit_date DESC, a.visit_time DESC
");

$stmt->execute([$p['id']]);
$apps = $stmt->fetchAll();

/* گروه‌بندی برای تشخیص یک پزشک + یک روز */
$groups = [];

foreach($apps as $a){
    $key = $a['doctor_id'].'_'.$a['visit_date'];
    $groups[$key][] = $a;
}
?>

<?php if(count($apps)==0): ?>
    <a href="appointments.php">
    <span class="badge">بدون نوبت</span>
<?php endif; ?>

<?php foreach($groups as $group): ?>
    <?php foreach($group as $i => $a): ?>

        <div style="margin:5px;padding:6px;border-radius:10px;"
             class="<?= count($group)>1 ? 'group-warning' : '' ?>">

            👨‍⚕️ <?= $a['doctor_name'] ?> |
            📅 <?= $a['visit_date'] ?> |
            ⏰ <?= $a['visit_time'] ?>

            <?php if(count($group)>1 && $i==0): ?>
                <span class="badge">⚠ چند نوبت یک روز</span>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>
<?php endforeach; ?>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</div>

</body>
</html>