<?php 

require_once __DIR__ . "/layout/header.php";

// چون index.php در پوشه اصلی است، مستقیماً به پوشه config می‌رود
require_once "config/config.php";


if(isset($_GET['cat'])){
    $cat = $_GET['cat'];
    $posts = $conn->prepare("SELECT * FROM `posts` WHERE `category_id` = :CI");
    $posts->execute(['CI' => $cat]);
} else {
    $sql = "SELECT * FROM `posts`";
    $posts = $conn->query($sql);
}

$slider = $conn->query("SELECT * FROM `posts_slider`");
?>

               

            <main>
                <!-- Slider Section -->
                <section>
                    <div id="carousel" class="carousel slide">
                        <div class="carousel-indicators">
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="0"
                                class="active"
                            ></button>
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="1"
                            ></button>
                            <button
                                type="button"
                                data-bs-target="#carousel"
                                data-bs-slide-to="2"
                            ></button>
                        </div>
                        <div class="carousel-inner rounded">
                        <?php  
                            if($slider->rowCount() > 0){
                                foreach($slider as $slide){
                                $post_id=$slide['post_id'];
                                $tmp=$conn->query("SELECT * FROM `posts` WHERE `id`=$post_id");
                                $post=$tmp->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="carousel-item overlay carousel-height <?=($slide['active'])? 'active':'' ?>">
                                <img
                                    src="./assets/images/<?=$post['image']?>"
                                    class="d-block w-100"
                                    alt="post-image"
                                />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?=$post['title'] ?></h5>
                                    <p>
                                    <?=substr($post['body'],0,50) ?>
                                    </p>
                                </div>
                        </div>
                        
                        <?php
                            }
                        }
                        ?>
                        </div>
                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#carousel"
                            data-bs-slide="prev"
                        >
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#carousel"
                            data-bs-slide="next"
                        >
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </section>

                <!-- Content Section -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts Content -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <?php if($posts){
                                    foreach($posts as $post){

                                        $cat_id=$post['category_id'];
                                        $sql_1= "SELECT * FROM `categories` WHERE `id`=$cat_id";
                                        $tmp=$conn->query($sql_1);
                                        $category=$tmp->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <img
                                            src="./assets/images/<?= $post['image'] ?>"
                                            class="card-img-top"
                                            alt="post-image"
                                        />
                                        <div class="card-body">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h5 class="card-title fw-bold">
                                                <?= $post['title'] ?>
                                                </h5>
                                                <div>
                                                    <span
                                                        class="badge text-bg-secondary"
                                                        ><?= $category['title'] ?></span
                                                    >
                                                </div>
                                            </div>
                                            <p
                                                class="card-text text-secondary pt-3"
                                            >
                                            <?= substr($post['body'],0,200) ?>
                                            </p>
                                            <div
                                                class="d-flex justify-content-between align-items-center"
                                            >
                                                <a
                                                    href="single.php?post_id=<?=$post['id']?>"
                                                    class="btn btn-sm btn-dark"
                                                    >مشاهده</a
                                                >

                                                <p class="fs-7 mb-0">
                                                    نویسنده : <?= $post['author'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <?php
                        include "layout/sidebar.php";
                        ?>
                    </div>
                </section>
            </main>

            <!-- Footer Section -->
            <?php
                     include "layout/footer.php";
            ?>
<?php
include("config/config.php");

$doctors = $conn->query("SELECT * FROM doctors");
?>

<h2> لیست پزشکان</h2>

<style>
body{
    font-family:'Vazirmatn';
}

/* HERO TITLE */
.doctor-title{
    text-align:center;
    font-size:28px;
    margin:30px 0;
    font-weight:800;
    color:#2c3e50;
}

/* GRID */
.doctor-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
    padding:20px;
}

/* CARD */
.doctor-card{
    background:linear-gradient(145deg,#ffffff,#f5f7ff);
    border-radius:20px;
    padding:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.3s;
    border:1px solid #eee;
}

.doctor-card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
}

/* NAME */
.doctor-card h3{
    margin:0;
    font-size:20px;
    color:#2c3e50;
}

/* BUTTONS */
.btn{
    display:inline-block;
    padding:10px 14px;
    margin:5px 5px 0 0;
    border-radius:12px;
    font-size:13px;
    text-decoration:none;
    color:white;
}

.btn-blue{
    background:linear-gradient(135deg,#667eea,#764ba2);
}

.btn-dark{
    background:linear-gradient(135deg,#2c3e50,#34495e);
}

/* REVIEW BOX */
.review{
    margin-top:10px;
    padding:10px;
    background:#f8f9ff;
    border-radius:10px;
    font-size:13px;
    border:1px solid #eee;
}

.badge{
    display:inline-block;
    padding:3px 8px;
    border-radius:8px;
    background:#ff9800;
    color:white;
    font-size:11px;
}
</style>



<style>
body{
    font-family:'Vazirmatn';
}

/* HERO TITLE */
.doctor-title{
    text-align:center;
    font-size:28px;
    margin:30px 0;
    font-weight:800;
    color:#2c3e50;
}

/* GRID */
.doctor-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
    padding:20px;
}

/* CARD */
.doctor-card{
    background:linear-gradient(145deg,#ffffff,#f5f7ff);
    border-radius:20px;
    padding:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.3s;
    border:1px solid #eee;
}

.doctor-card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
}

/* NAME */
.doctor-card h3{
    margin:0;
    font-size:20px;
    color:#2c3e50;
}

/* BUTTONS */
.btn{
    display:inline-block;
    padding:10px 14px;
    margin:5px 5px 0 0;
    border-radius:12px;
    font-size:13px;
    text-decoration:none;
    color:white;
}

.btn-blue{
    background:linear-gradient(135deg,#667eea,#764ba2);
}

.btn-dark{
    background:linear-gradient(135deg,#2c3e50,#34495e);
}

/* REVIEW BOX */
.review{
    margin-top:10px;
    padding:10px;
    background:#f8f9ff;
    border-radius:10px;
    font-size:13px;
    border:1px solid #eee;
}

.badge{
    display:inline-block;
    padding:3px 8px;
    border-radius:8px;
    background:#ff9800;
    color:white;
    font-size:11px;
}
</style>


<div class="doctor-grid">

<?php foreach($doctors as $doc): ?>

<div class="doctor-card">

    <h3>🩺 <?= $doc['name']; ?></h3>

    <a class="btn btn-blue" href="dashboard/nobat sit.php?doctor_id=<?= $doc['id']; ?>">
        📅 نوبت بگیر
    </a>

    <a class="btn btn-dark" href="dashboard/reviews.php?doctor_id=<?= $doc['id']; ?>">
        💬 ثبت نظر
    </a>

    <hr>

    <?php
    $reviews = $conn->prepare("
        SELECT * FROM reviews WHERE doctor_id=? ORDER BY id DESC
    ");
    $reviews->execute([$doc['id']]);

    foreach($reviews as $r):
    ?>
        <div class="review">
            ⭐ <?= $r['rating']; ?> <br>
            <?= $r['comment']; ?>
        </div>
    <?php endforeach; ?>

</div>

<?php endforeach; ?>

</div>