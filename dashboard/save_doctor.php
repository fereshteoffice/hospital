<?php
session_start();
include("../config/config.php");

// چک ادمین
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    if(empty($name) || empty($specialty)){
        echo "<script>
                alert('❌ لطفا فیلدهای ضروری را پر کنید');
                window.location.href='add_doctor.php';
              </script>";
        exit();
    }

    // ✅ اصلاح شد (PDO)
    $check = $conn->prepare("SELECT id FROM doctors WHERE email = ?");
    $check->execute([$email]);
    $result = $check->fetchAll();

    if(count($result) > 0){
        echo "<script>
                alert('❌ این دکتر قبلا ثبت شده است');
                window.location.href='add_doctor.php';
              </script>";
        exit();
    }

    // ✅ اصلاح شد (PDO)
    $stmt = $conn->prepare("INSERT INTO doctors (name, specialty, phone, email) VALUES (?, ?, ?, ?)");
    
    if($stmt->execute([$name, $specialty, $phone, $email])){
        echo "<script>
                alert('✅ دکتر با موفقیت ثبت شد');
                window.location.href='add_doctor.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ خطا در ذخیره اطلاعات');
                window.location.href='add_doctor.php';
              </script>";
    }
}
?>