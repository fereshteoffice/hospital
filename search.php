<?php 
include "layout/header.php";
include "config/config.php";

// گرفتن مقدار سرچ از URL
$search = trim($_GET['search'] ?? '');
$results = [];

if (!empty($search)) {

    $stmt = $conn->prepare("
        SELECT posts.*, categories.title AS cat_title 
        FROM posts 
        JOIN categories ON posts.category_id = categories.id
        WHERE posts.title LIKE :s 
           OR posts.body LIKE :s
           OR categories.title LIKE :s
    ");

    $stmt->execute([
        's' => "%$search%"
    ]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main>
<section class="mt-4">
<div class="row">

<div class="col-lg-8">

    <!-- پیام جستجو -->
   <?php if (isset($_GET['search']) && $search !== '') { ?>
    <div class="alert alert-secondary">
        پست‌های مرتبط با کلمه 
        <strong><?= htmlspecialchars($search) ?></strong>
    </div>
<?php } ?>
   <?php if (isset($_GET['search']) && $search !== '' && empty($results)) { ?>
    <div class="alert alert-danger">
        هیچ مقاله‌ای پیدا نشد 😔
    </div>
<?php } ?>

    <div class="row g-3">

    <!-- نمایش نتایج -->
    <?php if (!empty($results)) { ?>
        <?php foreach ($results as $row) { ?>

            <div class="col-sm-6">
                <div class="card">

                    <img src="./assets/images/<?= htmlspecialchars($row['image']) ?>" class="card-img-top"/>

                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <h5 class="card-title fw-bold">
                                <?= htmlspecialchars($row['title']) ?>
                            </h5>

                            <span class="badge text-bg-secondary">
                                <?= htmlspecialchars($row['cat_title']) ?>
                            </span>
                        </div>

                        <p class="card-text text-secondary pt-3">
                            <?= mb_substr(strip_tags($row['body']), 0, 100) ?>...
                        </p>

                        <div class="d-flex justify-content-between align-items-center">

                            <a href="single.php?post_id=<?= $row['id'] ?>" class="btn btn-sm btn-dark">
                                مشاهده
                            </a>

                            <p class="fs-7 mb-0">
                                نویسنده: <?= htmlspecialchars($row['author']) ?>
                            </p>

                        </div>

                    </div>
                </div>
            </div>

        <?php } ?>
    <?php } ?>

    </div>

</div>
</div>
</section>
</main>

<?php include "layout/footer.php"; ?>