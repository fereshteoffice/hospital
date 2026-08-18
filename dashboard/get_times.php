<?php
include("../config/config.php");

if(isset($_POST['date']) && isset($_POST['doctor_id'])){

    $date = $_POST['date'];
    $doctor_id = $_POST['doctor_id'];

    // ⏰ لیست ساعت‌ها
    $times = [];

for($hour = 9; $hour <= 20; $hour++){
    $times[] = str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00";
};

    echo "<option value=''>انتخاب ساعت</option>";

    foreach($times as $time){

        // چک رزرو بودن
        $check = $conn->prepare("
            SELECT * FROM appointments 
            WHERE doctor_id=? AND visit_date=? AND visit_time=?
        ");
        $check->execute([$doctor_id,$date,$time]);

        if($check->rowCount() == 0){
            echo "<option value='$time'>$time</option>";
        }
    }

}else{
    echo "<option>خطا در دریافت</option>";
}
?>