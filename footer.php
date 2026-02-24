<?php include("conn.php"); 

$query = "SELECT * FROM users WHERE id='1'";
if($sql_query = $conn->query($query))
{
if($sql_query->num_rows>0)
{
$result = $sql_query->fetch_array(MYSQLI_ASSOC);
$name = $result['name'];
$company_name = $result['company_name'];
$email = $result['email'];
$enquiry_email = $result['enquiry_email'];
$mobile = $result['mobile'];
// $landline_no = $result['landline_no'];
$whatsapp_number = $result['whatsapp_number'];
$customer_support_number = $result['customer_support_number'];
$paytm_number = $result['paytm_number'];
$paytm_file = $result['paytm_file'];
$fax_number = $result['fax_number'];
$working_hours = $result['working_hours'];
$working_hours1 = $result['working_hours1'];
$working_hours2 = $result['working_hours2'];
$working_hours3 = $result['working_hours3'];
$working_hours4 = $result['working_hours4'];
$working_hours5 = $result['working_hours5'];
$address = $result['address'];
$state = $result['state'];
$city = $result['city'];
$pin_code = $result['pin_code'];
$head_office = $result['head_office'];
// $office_email = $result['office_email'];
$office_number = $result['office_number'];
$google_map = $result['google_map'];
$country = $result['country'];
$website = $result['website'];
$catalog_url = $result['catalog_url'];
$skype_link = $result['skype_link'];
$facebook_link = $result['facebook_link'];
$twittter_link = $result['twittter_link'];
$linkedin_link = $result['linkedin_link'];
$instagram_link = $result['instagram_link'];
$youtube_link = $result['youtube_link'];
$pinterest_link = $result['pinterest_link'];
$others_link = $result['others_link'];
// $live_chat_code = $result['live_chat_code'];
$visitor_vounter_code = $result['visitor_vounter_code'];
$language_converter_code = $result['language_converter_code'];
// $google_map1 = $result['google_map1'];
$blog_url = $result['blog_url'];
$designed_dev = $result['designed_dev'];
$copyright = $result['copyright'];
$domain_name = $result['domain_name'];
$out_going_server = $result['out_going_server'];
$server_email = $result['server_email'];
$server_email_password = $result['server_email_password'];
}
}

?>
 <footer class="footer-area">
         <div class="footer-widget">
            <div class="container">
               <div class="row footer-widget-wrapper pt-50 pb-10">
                  <div class="col-md-6 col-lg-4">
                     <div class="footer-widget-box about-us">
                        <h4 class="footer-widget-title">Contact Details (Head Office)</h4>
                        <ul class="footer-contact">
                           <!-- <li><i class="far fa-home"></i>  AMAZING INFOTECH PRIVATE LIMITED</li> -->
                           <li><i class="far fa-home"></i>  <?=$company_name?></li>

                           <!-- <li><a href="tel:+91-9971314354"><i class="far fa-phone"></i>+91-9971314354, 8800520198 </a></li> -->
                           <li><a href="tel:+91-9971314354"><i class="far fa-phone"></i>+91-<?=$customer_support_number?>, <?=$mobile?> </a></li>

                           <!-- <li><i class="far fa-map-marker-alt"></i> Ground Floor, 48, Village Hasanpur, Near Reliance Fresh, I.P Extension, New Delhi, 110092</li> -->
                           <li><i class="far fa-map-marker-alt"></i><?=$address?></li>

                           <!-- <li><a href="mailto:support@amazinginfotech.in"><i class="far fa-envelope"></i> support@amazinginfotech.in, sales@amazinginfotech.in</a></li> -->
                           <li><a href="mailto:<?=$email?>"><i class="far fa-envelope"></i> <?=$email?>,<br> <?=$enquiry_email?></a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                     <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Quick Links</h4>
                        <ul class="footer-list">
                           <li><a href="<?=$site?>about-us.php"><i class="fas fa-dot-circle"></i> About Us</a></li>
                           <li><a href="<?=$site?>our-branches.php"><i class="fas fa-dot-circle"></i> Our Branches</a></li>
                           <li><a href="<?=$site?>careers.php"><i class="fas fa-dot-circle"></i> Careers</a></li>
                           <li><a href="<?=$site?>news-and-events.php"><i class="fas fa-dot-circle"></i> News & Events</a></li>
                           <li><a href="<?=$site?>contact-us.php"><i class="fas fa-dot-circle"></i> Contact us</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Our Products</h4>
                        <ul class="footer-list">
   <?php
                    $sql ="SELECT * FROM `cat_prod` WHERE sub_category_id = '0' AND status = '1'";
                    $res = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                        $category_name = $row['ct_pd_name'];
                        $category_id = $row['id'];
                                         $product_url = $row['ct_pd_url'];  
                    
                    ?>
                           <li><a href="<?php echo $site ?>products.php?category=<?php echo $product_url; ?>"><i class="fas fa-dot-circle"></i><?php echo $category_name;?></a></li>
                           <?php
                    }
                    ?>
                       </ul>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                     <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Newsletter</h4>
                        <div class="footer-newsletter">
                           <p>Subscribe Our Newsletter To Get Latest Update And News</p>
                           <div class="subscribe-form">
                              <form action="#">
                                <div class="g-recaptcha" data-sitekey="6Lf__TwrAAAAALKz4Z0g7EYSkE297cwgS9z5L5Xn"></div>
                                 <input type="email" class="form-control" placeholder="Your Email">
                                 <button class="theme-btn" type="submit">
                                 Subscribe Now <i class="far fa-paper-plane"></i>
                                 </button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-md-6 align-self-center">
                     <p class="copyright-text">
                        <!-- &copy; Copyright <span id="date"></span> <a href="#">  AMAZING INFOTECH PRIVATE LIMITED </a> All Rights Reserved. -->
                        ©<?=$copyright?>
                  </div>
                  <div class="col-md-6 align-self-center">
                     <ul class="footer_links">
                         <li><a href="<?=$site?>terms-and-conditions.php">Terms & Conditions</a></li>
                         <li><a href="<?=$site?>privacy-policy.php">Privacy Policy</a></li>
                         <li><a href="<?=$site?>return-policy.php">Return Policy</a></li>
                         <li><a href="<?=$site?>refund-policy.php">refund policy</a></li>
                            <li><a href="<?=$site?>shipping-policy.php">shipping policy</a></li>
                     </ul>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </footer>
<a href="#" id="scroll-top"><i class="fas fa-angle-up"></i></a>
      <script src="assets/js/jquery-3.7.1.min.js"></script>
      <script src="assets/js/modernizr.min.js"></script>
      <script src="assets/js/bootstrap.bundle.min.js"></script>
      <script src="assets/js/imagesloaded.pkgd.min.js"></script>
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <script src="assets/js/isotope.pkgd.min.js"></script>
      <script src="assets/js/jquery.appear.min.js"></script>
      <script src="assets/js/jquery.easing.min.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
      <script src="assets/js/counter-up.js"></script>
      <script src="assets/js/masonry.pkgd.min.js"></script>
      <script src="assets/js/wow.min.js"></script>
      <script src="assets/js/main.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>