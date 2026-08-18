<?php
$sql = "SELECT * FROM `categories`";
$cats = $conn->query($sql);

if (isset($_POST['sub_name']) && isset($_POST['sub_email'])) {
    $sub_in = $conn->prepare("INSERT INTO `subscribers` (`id`, `name`, `email`) VALUES (NULL, :N, :E)");
    $sub_in->execute(['N' => $_POST['sub_name'], 'E' => $_POST['sub_email']]);
    echo "<script>alert('✔ عضویت شما با موفقیت ثبت شد');</script>";
}
?>

<div class="col-lg-4">

    <!-- STYLE -->
    <style>
        .glass-card{
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 18px;
            overflow: hidden;
        }

        .glass-header{
            background: linear-gradient(135deg,#667eea,#764ba2);
            color:white;
            padding:12px 15px;
            font-weight:bold;
        }

        .glass-body{
            padding:15px;
        }

        .search-input{
            border-radius:12px;
            border:1px solid #ddd;
            padding:12px;
        }

        .btn-modern{
            background: linear-gradient(135deg,#667eea,#764ba2);
            border:none;
            color:white;
            padding:10px 14px;
            border-radius:12px;
        }

        .category-item a{
            display:block;
            padding:8px 5px;
            transition:0.3s;
            border-radius:8px;
        }

        .category-item a:hover{
            background:#f0f2ff;
            padding-right:10px;
        }

        .active-cat{
            font-weight:bold;
            color:#5b5be6;
        }

        .text-muted-small{
            font-size:13px;
            color:#777;
        }
    </style>

    <!-- SEARCH -->
    <div class="glass-card">
        <div class="glass-header">🔎 جستجو هوشمند</div>
        <div class="glass-body">
            <form action="search.php" method="GET">
                <input type="text" name="search" class="form-control search-input mb-2"
                       placeholder="جستجو پزشک، مقاله، خدمات...">
                <button class="btn-modern w-100">جستجو</button>
            </form>
        </div>
    </div>

    <!-- CATEGORIES -->
    <div class="glass-card">
        <div class="glass-header">🏥 دسته‌بندی تخصصی</div>
        <div class="glass-body">

            <div class="category-item">
                <?php foreach($cats as $cat){ ?>
                    <a href="index.php?cat=<?=$cat['id']?>"
                       class="<?=(isset($_GET['cat']) && $_GET['cat']==$cat['id']) ? 'active-cat' : '' ?>">
                        • <?=$cat['title']?>
                    </a>
                <?php } ?>

                <a href="index.php" class="mt-2 d-block text-muted-small">
                    ← مشاهده همه خدمات
                </a>
            </div>

        </div>
    </div>

    <!-- SUBSCRIBE -->
    <div class="glass-card">
        <div class="glass-header">📩 خبرنامه سلامت</div>
        <div class="glass-body">

            <p class="text-muted-small">
                جدیدترین مقالات پزشکی و سلامت را دریافت کنید
            </p>

            <form method="post">
                <input type="text" name="sub_name" class="form-control search-input mb-2"
                       placeholder="نام کامل" required>

                <input type="email" name="sub_email" class="form-control search-input mb-2"
                       placeholder="ایمیل" required>

                <button class="btn-modern w-100">عضویت</button>
            </form>

        </div>
    </div>

    <!-- ABOUT -->
    <div class="glass-card">
        <div class="glass-header">🏥 درباره مرکز درمانی</div>
        <div class="glass-body">

            <p style="line-height:1.9;font-size:14px;color:#444">
                این مرکز با استفاده از پزشکان متخصص و تجهیزات مدرن،
                خدمات درمانی دقیق، سریع و حرفه‌ای ارائه می‌دهد.
                هدف ما سلامت کامل بیماران در محیطی امن و استاندارد است.
            </p>

        </div>
    </div>

</div>