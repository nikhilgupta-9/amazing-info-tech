<?php
include("conn.php");


$query_select = "SELECT * FROM logo WHERE 1";
if ($sql_select = $conn->query($query_select)) {
    if ($sql_select->num_rows > 0) {
        $result = $sql_select->fetch_array(MYSQLI_ASSOC);
        $logo_title = stripslashes($result['logo_title']);
        $logo_image = $result['logo_image'];
        $fav_icon_image = $result['fav_icon_image'];
        $left_logo = $result['left_logo'];
        $center_logo = $result['center_logo'];
        $right_logo = $result['right_logo'];
        $footer_logo = $result['footer_logo'];
        $iso_logo = $result['iso_logo'];
        $pagetaskname = " Update ";
    }

}

?>
<style>
    .nav-item {


        list-style: none;
        font-size: 13px;

    }
</style>
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-top-wrap">
                <div class="header-top-left">
                    <div class="header-top-social">
                        <span>Follow Us:</span>
                        <a href="https://www.facebook.com/AmazingInfotech.Official" target="_blank"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/amazing_infotech/" target="_blank"><i
                                class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@AmazingInfotechOfficial" target="_blank"><i
                                class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/company/amazing-infotech-pvt-ltd-india/" target="_blank"><i
                                class="fa-brands fa-linkedin"></i></a>
                        <!--<a href="https://www.pinterest.com/amazinginfotechpvtltd/" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>-->
                    </div>
                </div>
                <div class="header-top-right">
                    <div class="header-top-contact">
                        <ul>
                            <li>
                                <div class="header-top-contact-info">
                                    <a href="tel:9971314354"><i class="far fa-phone"></i> +91-9971314354</a>
                                </div>
                            </li>
                            <li>
                                <div class="header-top-contact-info">
                                    <a href="mailto:sales@amazinginfotech.in"><i class="far fa-envelope"></i>
                                        sales@amazinginfotech.in</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">
                <a class="navbar-brand" href="<?= $site ?>index.php">
                    <img src="<?= $site ?>assets/img/logo-new.png" alt="Amazing Infotech Logo">
                </a>
                <div class="mobile-menu-right">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <a href="index.php" class="offcanvas-brand" id="offcanvasNavbarLabel">
                            <img src="admin/uploads/logo/<?php echo $result['logo_image']; ?>"
                                alt="Amazing Infotech Logo">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="<?= $site ?>index.php">Home</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="<?= $site ?>about-us.php">About Us</a></li>
                            <li class="menu-icon">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Our Products</a>
                                <ul class="dropdown-menu fade-down">
                                    <?php
                                    // Fetch top-level categories (parent categories)
                                    $categories_query = mysqli_query($conn, "SELECT * FROM cat_prod WHERE sub_category_id = '0' AND status = '1'");

                                    while ($category = mysqli_fetch_assoc($categories_query)) {
                                        $category_name = htmlspecialchars($category['ct_pd_name']);
                                        $category_url = htmlspecialchars($category['ct_pd_url']);
                                        // $id = htmlspecialchars($category['id']);
                                    
                                        ?>
                                        <li class="menu-item">
                                            <a href="<?= $site ?>products.php?category=<?= $category_url ?>"
                                                class="nav-link">
                                                <?= $category_name ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="<?= $site ?>assets/certificate_merged.pdf"
                                    target="_blank">Our Certificate</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= $site ?>our-branches.php">Our
                                    Branches</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="<?= $site ?>careers.php">Careers</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= $site ?>supplies-and-amc.php">Supplies &
                                    AMC</a></li>
                            <li class="menu-icon">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Events &
                                    Awards</a>
                                <ul class="dropdown-menu fade-down">
                                    <li class="menu-item">
                                        <a class="nav-link" href="<?= $site ?>news-and-events.php">Awards</a>
                                    </li>
                                    <li class="menu-item">
                                        <a class="nav-link" href="<?= $site ?>events.php">Events</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="<?= $site ?>contact-us.php">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>



<!-- Floating Contact Buttons -->
<div class="floating-contact-buttons">
    <a href="https://wa.me/918800520198" class="float-btn whatsapp-btn" target="_blank" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="tooltip">Chat with us</span>
    </a>
    <a href="tel:+918800520198" class="float-btn call-btn" title="Call Us">
        <i class="fas fa-phone-alt"></i>
        <span class="tooltip">Call us</span>
    </a>
</div>

<style>
    /* Floating Contact Buttons Styles */
    .floating-contact-buttons {
        position: fixed;
        bottom: 80px;
        right: 24px;
        z-index: 999;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .float-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        position: relative;
        text-decoration: none;
    }

    .whatsapp-btn {
        background-color: #25D366;
    }

    .call-btn {
        background-color: #007bff;
    }

    .float-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .tooltip {
        position: absolute;
        right: 70px;
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .float-btn:hover .tooltip {
        opacity: 1;
        visibility: visible;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .floating-contact-buttons {
            bottom: 15px;
            right: 15px;
        }

        .float-btn {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .tooltip {
            right: 60px;
            font-size: 12px;
        }
    }
</style>

<!-- Make sure Font Awesome is included in your head -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf__TwrAAAAALKz4Z0g7EYSkE297cwgS9z5L5Xn"></script>