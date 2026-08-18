<?php
require_once __DIR__ . '/../config/config.php';
$sql="SELECT * FROM `categories`";
$cats=$conn->query($sql);
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>php tutorial || blog project</title>

        <!-- <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        /> -->
        <!-- <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
            crossorigin="anonymous"
        /> -->
        <link
            href="./assets/css/bootstrap.min.css"
            rel="stylesheet"
        />

        <link rel="stylesheet" href="./assets/css/style.css" />
    </head>

    <body>
        <div class="container py-3">
            <header
                class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom"
            >
                <a
                    href="index.php"
                    class="fs-4 fw-medium link-body-emphasis text-decoration-none"
                >
                    weblog
                </a>

                <nav class="d-inline-flex mt-2 mt-md-0 me-md-auto">
                    <?php
                    foreach($cats as $cat){
                    ?>
                    <a
                        class="<?=(isset($_GET['cat']) and $_GET['cat']==$cat['id'])? 'fw-bold':'' ?> me-3 py-2 link-body-emphasis text-decoration-none"
                        href="index.php?cat=<?=$cat['id']?>"
                        ><?php echo $cat['title'] ?></a
                    >
                    <?php
                    }
                    ?>
                </nav>
                
            </header>
            <style>
/* ===== HEADER WRAPPER ===== */
.lux-header{
    background:rgba(255,255,255,0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border:1px solid rgba(255,255,255,0.3);
    border-radius:20px;
    padding:15px 20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* LOGO */
.lux-logo{
    font-size:22px;
    font-weight:800;
    background:linear-gradient(135deg,#667eea,#764ba2);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    text-decoration:none;
}

/* NAV */
.lux-nav{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

/* LINKS */
.lux-nav a{
    padding:8px 14px;
    border-radius:12px;
    text-decoration:none;
    color:#333;
    font-size:14px;
    transition:0.3s;
    background:rgba(0,0,0,0.03);
}

/* HOVER */
.lux-nav a:hover{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    transform:translateY(-2px);
}

/* ACTIVE */
.lux-nav a.active{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    font-weight:600;
}
</style>

<div class="container py-3">

<header class="lux-header d-flex flex-column flex-md-row align-items-center justify-content-between">

    <!-- LOGO -->
    <a href="index.php" class="lux-logo">
        🏥 Hospital Razavi
    </a>

    <!-- NAV -->
    <nav class="lux-nav mt-3 mt-md-0">

        <a href="index.php" class="<?= !isset($_GET['cat']) ? 'active' : '' ?>">
            همه
        </a>

        <?php foreach($cats as $cat): ?>
            <a class="<?= (isset($_GET['cat']) && $_GET['cat']==$cat['id']) ? 'active' : '' ?>"
               href="index.php?cat=<?= $cat['id'] ?>">
                <?= $cat['title'] ?>
            </a>
        <?php endforeach; ?>

    </nav>

</header>