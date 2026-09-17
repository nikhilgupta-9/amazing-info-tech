<?php
include("conn.php");
// Get the URL alias from the GET request
$url = mysqli_real_escape_string($conn, $_GET['alias']);

// Query to get the subcategory based on the `ct_pd_url`
$query = "SELECT * FROM cat_prod WHERE ct_pd_url = '$url' AND status = '1' LIMIT 1";
$header = mysqli_query($conn, $query);

if (mysqli_num_rows($header) > 0) {
    $header1 = mysqli_fetch_assoc($header);
    $subcategory_id = $header1['id']; // Get the subcategory ID
    $subcategory_name = $header1['ct_pd_name']; // Get the subcategory name
    $product_images = explode(",", $header1['cat_pd_image']); // Split image filenames
    $price = $header1['cat_pd_price'];
    $mrp = $header1['cat_pd_mrp'];
    $long_desc = $header1['long_description'];
    $short_desc = $header1['small_description'];
    $gallery_images = array_values(array_filter(array_map('trim', explode(',', (string) $header1['cat_pd_image']))));
}
// Fetch products under the specified subcategory using `sub_category_id`
$sub_cat_query = "SELECT * FROM `cat_prod` WHERE sub_category_id = '$subcategory_id' AND status = '1'";
$sub_cat_result = mysqli_query($conn, $sub_cat_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="<?= $header1['ct_pd_mt_ds'] ?>" content>
    <link rel="canonical" href="<?= $header1['ct_pd_ky'] ?>">
    <title> <?= $header1['ct_pd_title'] ?> || Amazing Infotech Pvt. Ltd.</title>
    <meta name="robots" content="index, allow" />
    <meta name="googlebot" content="index, allow" />
    <meta name="author" content="Amazing Infotech" />
    <link rel="stylesheet" href="<?= $site ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/style.css">
</head>

<body class="home-3 product-detail-page">
    <?php include('header.php') ?>

    <main class="main">

        <div class="site-breadcrumb product-breadcrumb" style="background: url(<?=$site?>assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title"><?php echo $subcategory_name; ?></h2>
                <ul class="breadcrumb-menu">
                    <li><a href="<?= $site ?>index.php">Home</a></li>
                    <li class="active"><?php echo $subcategory_name; ?></li>
                </ul>
            </div>
        </div>
        <div class="service-single-area product-detail-area py-120">
            <div class="container">
                <div class="service-single-wrapper">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <aside class="service-sidebar product-sidebar">
                                <div class="widget category product-category-card">
                                    <span class="product-sidebar-label">Explore</span>
                                    <h4 class="widget-title">Other Products</h4>
                                    <div class="category-list">
                                        <?php


                                        $sub_cat = "SELECT * FROM `cat_prod` WHERE sub_category_id != '0' AND status = '1'";
                                        $res2 = mysqli_query($conn, $sub_cat);


                                        while ($product_row = mysqli_fetch_assoc($res2)) {

                                            //    print_r($product_row['id']);
                                            $sub_cat_pro = htmlspecialchars($product_row['ct_pd_name']);
                                            $product_url = htmlspecialchars($product_row['ct_pd_url']);
                                            $cat_pd_price = htmlspecialchars($product_row['cat_pd_price']);

                                            ?>
                                            <a href="<?= $site ?>product-details/<?= $product_url ?>"><i
                                                    class="far fa-angle-double-right"></i><?= $sub_cat_pro ?></a>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                            </aside>
                        </div>
                        <div class="col-xl-9 col-lg-8">
                            <article class="product-detail-card">
                                <div class="product-detail-gallery">
                                    <div class="product-main-image">
                                        <?php if (!empty($gallery_images[0])): ?>
                                            <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= htmlspecialchars($gallery_images[0], ENT_QUOTES, 'UTF-8') ?>"
                                                alt="<?= htmlspecialchars($subcategory_name, ENT_QUOTES, 'UTF-8') ?>">
                                        <?php else: ?>
                                            <span class="product-image-fallback"><i class="fas fa-print"></i></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (count($gallery_images) > 1): ?>
                                        <div class="product-thumbnails">
                                            <?php foreach (array_slice($gallery_images, 0, 4) as $gallery_image): ?>
                                                <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= htmlspecialchars($gallery_image, ENT_QUOTES, 'UTF-8') ?>"
                                                    alt="<?= htmlspecialchars($subcategory_name, ENT_QUOTES, 'UTF-8') ?>">
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-detail-content">
                                    <span class="product-eyebrow"><i class="fas fa-check-circle"></i> Genuine HP plotter
                                        solution</span>
                                    <h1><?php echo htmlspecialchars($subcategory_name, ENT_QUOTES, 'UTF-8'); ?></h1>
                                    <div class="product-price"><i class="fa-solid fa-indian-rupee-sign"></i>
                                        <?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?><span>/ Unit</span>
                                    </div>
                                    <p class="product-lead">
                                        <?php echo htmlspecialchars($short_desc, ENT_QUOTES, 'UTF-8'); ?></p>
                                    <div class="product-feature-heading"><i class="fas fa-layer-group"></i> Product
                                        highlights</div>
                                    <div class="product-description"><?php echo $long_desc; ?></div>

                                    <!--<form action="https://amazinginfotech.in/process_payment.php" method="post">-->
                                    <form action="<?php echo SITE_URL ?>ww-phonepe.php" method="post">

                                        <input type="hidden" name="product_id" value="<?php echo $subcategory_id; ?>">
                                        <input type="hidden" name="payaction" value="buy_product">

                                        <button type="submit" id="payNow" name="payNow" class="product-buy-button"><i
                                                class="fas fa-shopping-bag"></i> Buy Now</button>
                                        <a class="product-contact-button" href="<?= $site ?>contact-us.php"><i
                                                class="fas fa-headset"></i> Talk to an expert</a>

                                    </form>


                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include('footer.php') ?>
</body>

</html>