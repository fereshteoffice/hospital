<?php 
include "layout/header.php";
include "config/config.php";

if(isset($_GET['post_id'])){
    $post_id=$_GET['post_id'];
    $post=$conn->prepare("SELECT * FROM `posts` WHERE `id`= :PID");
    $post->execute(['PID'=>$post_id]);
    $pst=$post->fetch(PDO::FETCH_ASSOC);
    $ps=$pst['category_id'];
    $sql_1= "SELECT * FROM `categories` WHERE `id`=$ps";
    $tmp=$conn->query($sql_1);
    $category=$tmp->fetch(PDO::FETCH_ASSOC);
    $comments=$conn->prepare("SELECT * FROM `comments` WHERE `post_id` = :CM");
    $comments->execute(['CM'=>$post_id]);
}else{
    header('location:index.php');
}

// --- بخش اصلاح شده زیر است ---
if (isset($_POST['txtname']) and isset($_POST['txtcom'])) {
    // ستون id و مقدار NULL حذف شد تا دیتابیس خودش شماره بدهد
    $comment_in = $conn->prepare("INSERT INTO `comments` (`name`, `comment`, `post_id`, `status`) VALUES (:N, :C, :PID, '0')");
    $comment_in->execute(['N'=> $_POST['txtname'],'C'=> $_POST['txtcom'],'PID' => $post_id]);
    
    // رفرش صفحه برای نمایش کامنت جدید
    header("Location: post_details.php?post_id=$post_id");
    exit();
}
// ------------------------------

?>
            <main>
                <!-- Content -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts & Comments Content -->
                        <div class="col-lg-8">
                            <div class="row justify-content-center">
                                <!-- Post Section -->
                                <div class="col">
                                    <div class="card">
                                        <img
                                            src="./assets/images/<?=$pst['image']?>"
                                            class="card-img-top"
                                            alt="post-image"
                                        />
                                        <div class="card-body">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h5 class="card-title fw-bold">
                                                    <?=$pst['title']?>
                                                </h5>
                                                <div>
                                                    <span
                                                        class="badge text-bg-secondary"
                                                        ><?=$category['title']?></span
                                                    >
                                                </div>
                                            </div>
                                            <p
                                                class="card-text text-secondary text-justify pt-3"
                                            ><?=$pst['body']?>
                                            </p>
                                            <div>
                                                <p class="fs-6 mt-5 mb-0">
                                                    نویسنده :  <?=$pst['author']?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-4" />

                                <!-- Comment Section -->
                                <div class="col">
                                    <!-- Comment Form -->
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="fw-bold fs-5">
                                                ارسال کامنت
                                            </p>

                                            <form method="post" action="#">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >نام</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="txtname"
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >متن کامنت</label
                                                    >
                                                    <textarea
                                                        class="form-control"
                                                        rows="3"
                                                        name="txtcom"
                                                    ></textarea>
                                                </div>
                                                <button
                                                    type="submit"
                                                    class="btn btn-dark"
                                                >
                                                    ارسال
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <hr class="mt-4" />
                                    <!-- Comment Content -->
                                    <p class="fw-bold fs-6">تعداد کامنت : <?=$comments->rowCount(); ?></p>

                                     <?php
                                        foreach($comments as $comment){
                                     ?>

                                    <div class="card bg-light-subtle mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <img
                                                    src="./assets/images/profile.png"
                                                    width="45"
                                                    height="45"
                                                    alt="user-profle"
                                                />

                                                <h5
                                                    class="card-title me-2 mb-0"
                                                >
                                                    <?=$comment['name'] ?>
                                                </h5>
                                            </div>

                                            <p class="card-text pt-3 pr-3">
                                                <?=$comment['comment'] ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <?php
                        include "sidebar.php";
                        ?>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <?php
                     include "layout/footer.php";
            ?>
