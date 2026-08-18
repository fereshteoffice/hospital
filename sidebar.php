<?php
// دریافت دسته‌بندی‌ها از دیتابیس
$sql = "SELECT * FROM `categories`";
$cats = $conn->query($sql);

// پردازش فرم خبرنامه
if (isset($_POST['sub_name']) && isset($_POST['sub_email'])) {
    $sub_in = $conn->prepare("INSERT INTO `subscribers` (`id`, `name`, `email`) VALUES (NULL, :N, :E)");
    $sub_in->execute(['N' => $_POST['sub_name'], 'E' => $_POST['sub_email']]);
    echo "<script>alert('با تشکر! اطلاعات شما برای دریافت مقالات سلامت ثبت شد.');</script>";
}
?>

<div class="col-lg-4">
    <!-- بخش جستجو (Search Section) -->
    <div class="card">
        <div class="card-body">
            <p class="fw-bold fs-6">جستجو در مقالات و خدمات</p>
            <form action="search.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="مثلاً: نوبت دهی، پزشک...">
                    <button class="btn btn-primary" type="submit">جستجو</button>
                </div>
            </form>
        </div>
    </div>

    <!-- بخش دسته‌بندی‌ها (Categories Section) -->
    <div class="card mt-4">
        <div class="fw-bold fs-6 card-header">دسته‌بندی‌های تخصصی</div>
        <ul class="list-group list-group-flush p-0">
            <?php foreach($cats as $cat){ ?>
            <li class="list-group-item">
                <a class="<?=(isset($_GET['cat']) and $_GET['cat']==$cat['id'])? 'fw-bold text-primary':'' ?> link-body-emphasis text-decoration-none"
                   href="index.php?cat=<?=$cat['id']?>">
                   <?=$cat['title']?>
                </a>
            </li>
            <?php } ?>
            <li class="list-group-item">
                <a href="index.php" class="link-body-emphasis text-decoration-none <?=(isset($_GET['cat']))? '': 'fw-bold text-primary' ?>">
                    مشاهده همه دسته‌ها
                </a>
            </li>
        </ul>
    </div>

    <!-- بخش خبرنامه (Subscribe Section) -->
    <div class="card mt-4">
        <div class="card-body">
            <p class="fw-bold fs-6">عضویت در خبرنامه سلامت</p>
            <p class="small text-muted mb-3">آخرین مقالات آموزشی و توصیه‌های پزشکی را دریافت کنید.</p>

            <form method="post" action="#">
                <div class="mb-3">
                    <label class="form-label small">نام و نام خانوادگی</label>
                    <input type="text" class="form-control" name="sub_name" required placeholder="نام خود را وارد کنید" />
                </div>
                <div class="mb-3">
                    <label class="form-label small">آدرس ایمیل</label>
                    <input type="email" class="form-control" name="sub_email" required placeholder="example@mail.com" />
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-secondary">ثبت عضویت</button>
                </div>
            </form>
        </div>
    </div>

    <!-- بخش درباره ما (About Section) -->
    <div class="card mt-4">
        <div class="card-body">
            <p class="fw-bold fs-6">درباره مرکز ما</p>
            <p class="text-justify small" style="line-height: 1.8;">
                ما با هدف ارتقای سطح سلامت جامعه، مجموعه‌ای از متخصصین مجرب را گرد هم آورده‌ایم تا با بهره‌گیری از 
                مدرن‌ترین تجهیزات پزشکی و پروتکل‌های درمانی روز دنیا، بهترین خدمات مراقبتی را به شما ارائه دهیم. 
                سلامت شما، سرمایه اصلی ماست.
            </p>
        </div>
    </div>
</div>
