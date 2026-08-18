 <?php 
// نام دیتابیس را دقیقاً همان چیزی بگذارید که در phpMyAdmin ساخته‌اید
$dns = "mysql:host=localhost;dbname=hospital_we;charset=utf8";
$user = 'root';
$pass = "";

try {
    // ایجاد اتصال
    $conn = new PDO($dns, $user, $pass);
    
    // فعال کردن حالت گزارش خطا برای اینکه اگر کوئری اشتباه بود بفهمید
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // اگر اتصال برقرار نشد، دقیقاً بگو چه مشکلی وجود دارد
    die("خطا در اتصال به دیتابیس: " . $e->getMessage());
}
?>
