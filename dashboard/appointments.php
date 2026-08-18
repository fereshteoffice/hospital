<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$message = "";
$success = false;

// ساخت خودکار بیمار
$user_id = $_SESSION['user_id'];

$checkPatient = $conn->prepare("SELECT * FROM patients WHERE user_id=?");
$checkPatient->execute([$user_id]);
$patient = $checkPatient->fetch();

if(!$patient){
    $user = $conn->prepare("SELECT name FROM users WHERE id=?");
    $user->execute([$user_id]);
    $userData = $user->fetch();

    $name = $userData['name'] ?? 'کاربر';
    
    $insert = $conn->prepare("INSERT INTO patients (user_id, name) VALUES (?,?)");
    $insert->execute([$user_id, $name]);

    $patient_id = $conn->lastInsertId();
} else {
    $patient_id = $patient['id'];
}

// ثبت نوبت
if(isset($_POST['book'])){

    $doctor_id = $_POST['doctor_id'] ?? null;
    $date = $_POST['date'] ?? null;
    $time = $_POST['time'] ?? null;

    if(!$doctor_id || !$date || !$time){
        $message = "❌ لطفاً همه فیلدها را کامل کنید";
    } 
    else {

        $check = $conn->prepare("
            SELECT * FROM appointments 
            WHERE doctor_id=? AND visit_date=? AND visit_time=?
        ");
        $check->execute([$doctor_id,$date,$time]);

        if($check->rowCount() > 0){
            $message = "❌ این زمان قبلاً رزرو شده";
        }else{

            $stmt = $conn->prepare("
                INSERT INTO appointments 
                (patient_id, doctor_id, visit_date, visit_time)
                VALUES (?,?,?,?)
            ");

            $stmt->execute([$patient_id,$doctor_id,$date,$time]);

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
<meta name="viewport" content="width=device-width, initial-scale=1.2">
<title>رزرو نوبت</title>

<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Vazirmatn';
    background: linear-gradient(135deg, #667eea, #764ba2);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.container{
    width:520px;
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 20px 60px rgba(0,0,0,0.3);
}

h2{
    text-align:center;
    font-size:28px;
}

.subtitle{
    text-align:center;
    font-size:16px;
    color:#666;
    margin-bottom:20px;
}

select, input{
    width:100%;
    padding:18px;
    margin:12px 0;
    border-radius:12px;
    border:1px solid #ddd;
    font-size:18px;
}

button{
    width:100%;
    padding:18px;
    border:none;
    border-radius:12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color:white;
    font-size:19px;
    cursor:pointer;
}

.message{
    text-align:center;
    padding:14px;
    border-radius:10px;
    margin-bottom:10px;
    font-size:16px;
    background:#ffe5e5;
}

.message.success{
    background:#d4edda;
    color:#155724;
}
</style>
</head>

<body>

<div class="container">

<h2>🩺 رزرو نوبت</h2>
<div class="subtitle">لطفاً اطلاعات را کامل انتخاب کنید</div>

<?php if($message): ?>
<div class="message <?= $success ? 'success' : '' ?>">
    <?= $message ?>
</div>
<?php endif; ?>

<?php if(!$success): ?>
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

<input type="date" name="date" required>

<select name="time" id="timeSelect" required disabled>
<option value="">ابتدا پزشک و تاریخ را انتخاب کنید</option>
</select>

<button name="book">ثبت نوبت</button>

</form>
<?php endif; ?>

<br>
<a href="dashboard.php">
    <button type="button">🔙 بازگشت</button>
</a>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('input[name="date"], select[name="doctor_id"]').change(function(){

    let date = $('input[name="date"]').val();
    let doctor = $('select[name="doctor_id"]').val();

    if(date && doctor){

        $('#timeSelect').html('<option>در حال دریافت...</option>');
        $('#timeSelect').prop('disabled', true);

        $.post('get_times.php',{date:date,doctor_id:doctor},function(data){

            $('#timeSelect').html(data);
            $('#timeSelect').prop('disabled', false);

        }).fail(function(){
            $('#timeSelect').html('<option value="09:00">09:00</option><option value="10:00">10:00</option>');
            $('#timeSelect').prop('disabled', false);
        });

    }
});
</script>

</body>
</html>