<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$message = "";
$success = false;

$user_id = $_SESSION['user_id'];

/* =========================
   GET OR CREATE PATIENT
========================= */
$stmt = $conn->prepare("SELECT * FROM patients WHERE user_id=?");
$stmt->execute([$user_id]);
$patient = $stmt->fetch();

if(!$patient){

    $user = $conn->prepare("SELECT fullname FROM users WHERE id=?");
    $user->execute([$user_id]);
    $u = $user->fetch();

    $insert = $conn->prepare("
        INSERT INTO patients 
        (user_id, name, last_name, age, gender, phone, insurance_type, disease_type)
        VALUES (?,?,?,?,?,?,?,?)
    ");

    $insert->execute([
        $user_id,
     $u['fullname'] ?? '',
        '',
        '',
        '',
        '',
        '',
        ''
    ]);

    $stmt = $conn->prepare("SELECT * FROM patients WHERE user_id=?");
    $stmt->execute([$user_id]);
    $patient = $stmt->fetch();
}

/* =========================
   UPDATE + BOOK
========================= */
if(isset($_POST['book'])){

    $name = $_POST['name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $insurance_type = $_POST['insurance_type'] ?? '';
    $disease_type = $_POST['disease_type'] ?? '';

    $doctor_id = $_POST['doctor_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    /* =========================
       VALIDATION (همه اجباری)
    ========================= */
    if(
        !$name || !$last_name || !$age || !$gender || !$phone ||
        !$insurance_type || !$disease_type ||
        !$doctor_id || !$date || !$time
    ){
        $message = "❌ لطفاً همه فیلدها را کامل کنید";
    }
    else {

        /* آپدیت بیمار */
        $updatePatient = $conn->prepare("
            UPDATE patients 
            SET name=?, last_name=?, age=?, gender=?, phone=?, insurance_type=?, disease_type=?
            WHERE id=?
        ");

        $updatePatient->execute([
            $name,
            $last_name,
            $age,
            $gender,
            $phone,
            $insurance_type,
            $disease_type,
            $patient['id']
        ]);

        /* بررسی تداخل نوبت */
        $check = $conn->prepare("
            SELECT * FROM appointments 
            WHERE doctor_id=? AND visit_date=? AND visit_time=?
        ");

        $check->execute([$doctor_id,$date,$time]);

        if($check->rowCount() > 0){
            $message = "❌ این نوبت قبلاً رزرو شده";
        } else {

            $insert = $conn->prepare("
                INSERT INTO appointments 
                (patient_id, doctor_id, visit_date, visit_time)
                VALUES (?,?,?,?)
            ");

            $insert->execute([
                $patient['id'],
                $doctor_id,
                $date,
                $time
            ]);

            $message = "✅ نوبت با موفقیت ثبت شد";
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>رزرو نوبت</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Vazirmatn';
    background: linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
    justify-content:center;
    padding:30px;
}

.container{
    width:600px;
    background:white;
    padding:30px;
    border-radius:20px;
}

input, select{
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:10px;
    border:1px solid #ddd;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    cursor:pointer;
}

.message{
    padding:10px;
    margin-bottom:10px;
    border-radius:10px;
    background:#ffe5e5;
}

.message.success{
    background:#d4edda;
}

.back{
    width:100%;
    margin-top:10px;
    background:#333;
}
</style>
</head>

<body>

<div class="container">

<h2>🩺 رزرو نوبت + اطلاعات بیمار</h2>

<?php if($message): ?>
<div class="message <?= $success?'success':'' ?>">
    <?= $message ?>
</div>
<?php endif; ?>

<form method="POST">

<h3>👤 اطلاعات بیمار</h3>

<input type="text" name="name" value="<?= $patient['name'] ?>" placeholder="نام" required>
<input type="text" name="last_name" value="<?= $patient['last_name'] ?>" placeholder="نام خانوادگی" required>
<input type="number" name="age" value="<?= $patient['age'] ?>" placeholder="سن" required>

<select name="gender" required>
    <option value="">انتخاب جنسیت</option>
    <option value="male" <?= $patient['gender']=='male'?'selected':'' ?>>مرد</option>
    <option value="female" <?= $patient['gender']=='female'?'selected':'' ?>>زن</option>
</select>

<input type="text" name="phone" value="<?= $patient['phone'] ?>" placeholder="شماره" required>

<input type="text" name="insurance_type" value="<?= $patient['insurance_type'] ?>" placeholder="نوع بیمه" required>

<input type="text" name="disease_type" value="<?= $patient['disease_type'] ?>" placeholder="نوع بیماری" required>

<hr>

<h3>📅 نوبت</h3>

<select name="doctor_id" required>
<option value="">انتخاب پزشک</option>
<?php
$docs = $conn->query("SELECT * FROM doctors");
foreach($docs as $d){
    echo "<option value='{$d['id']}'>{$d['name']}</option>";
}
?>
</select>

<input type="date" name="date" required>

<select name="time" required>
    <option value="">⏰ انتخاب ساعت ویزیت</option>
    <?php
    $times = ["09:00","09:30","10:00","10:30","11:00","11:30","12:00","16:00","16:30","17:00","17:30","18:00"];
    foreach($times as $t){
        echo "<option value='$t'>🕒 $t</option>";
    }
    ?>
</select>

<button name="book">ثبت نوبت</button>

</form>

<!-- 🔙 BACK BUTTON -->
<a href="dashboard.php">
    <button type="button" class="back">🔙 بازگشت</button>
</a>

</div>

</body>
</html>