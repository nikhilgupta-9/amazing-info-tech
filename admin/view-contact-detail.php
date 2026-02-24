<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

$pagename = "contact";



/* set var blank */

$id = "";	

$response = "";	

$error = "";

$user_name = "";

$name = "";
$company_name ="";
$email ="";
$enquiry_email = ""; 
$mobile  = "";
$landline_no ="";
$whatsapp_number = "";
$customer_support_number ="";
$paytm_number  ="";
$paytm_file  ="";
$fax_number  ="";
$working_hours ="";
$working_hours1 ="";
$working_hours2  ="";
$working_hours3  ="";
$working_hours4  ="";
$working_hours5  ="";
$address   ="";
$state   ="";
$city   ="";
$pin_code  ="";
$head_office ="";
$office_email ="";
$office_number ="";
$google_map  ="";
$country  ="";
$website  ="";
$catalog_url ="";
$skype_link ="";
$facebook_link ="";
$twittter_link ="";
$linkedin_link ="";
$instagram_link ="";
$youtube_link ="";
$pinterest_link ="";
$others_link ="";
$live_chat_code ="";
$visitor_vounter_code ="";
$language_converter_code ="";
$google_map1 ="";
$blog_url ="";
$designed_dev ="";
$copyright ="";
$domain_name ="";
$out_going_server ="";
$server_email ="";
$server_email_password ="";
$query = "SELECT * FROM users ORDER BY id DESC";
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
$landline_no = $result['landline_no'];
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
$office_email = $result['office_email'];
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
$live_chat_code = $result['live_chat_code'];
$visitor_vounter_code = $result['visitor_vounter_code'];
$language_converter_code = $result['language_converter_code'];
$google_map1 = $result['google_map1'];
$blog_url = $result['blog_url'];
$designed_dev = $result['designed_dev'];
$copyright = $result['copyright'];
$domain_name = $result['domain_name'];
$out_going_server = $result['out_going_server'];
$server_email = $result['server_email'];
$server_email_password = $result['server_email_password'];
$id = $result['id'];
}
}



if(isset($_REQUEST['submit']) && $_REQUEST['submit']=="update")

{


$name = addslashes(trim($_POST['name']));
$company_name = addslashes(trim($_POST['company_name']));
$email = addslashes(trim($_POST['email']));
$enquiry_email = addslashes(trim($_POST['enquiry_email']));
$mobile = addslashes(trim($_POST['mobile']));
$landline_no = addslashes(trim($_POST['landline_no']));
$whatsapp_number = addslashes(trim($_POST['whatsapp_number']));
$customer_support_number = addslashes(trim($_POST['customer_support_number']));
$paytm_number = addslashes(trim($_POST['paytm_number']));
$fax_number = addslashes(trim($_POST['fax_number']));
$working_hours = addslashes(trim($_POST['working_hours']));
$working_hours1 = addslashes(trim($_POST['working_hours1']));
$working_hours2 = addslashes(trim($_POST['working_hours2']));
$working_hours3 = addslashes(trim($_POST['working_hours3']));
$working_hours4 = addslashes(trim($_POST['working_hours4']));
$working_hours5 = addslashes(trim($_POST['working_hours5']));
$address = addslashes(trim($_POST['address']));
$state = addslashes(trim($_POST['state']));
$city = addslashes(trim($_POST['city']));
$pin_code = addslashes(trim($_POST['pin_code']));
$head_office = addslashes(trim($_POST['head_office']));
$office_email = addslashes(trim($_POST['office_email']));
$office_number = addslashes(trim($_POST['office_number']));
$google_map = ($_POST['google_map']);
$country = addslashes(trim($_POST['country']));
$website = addslashes(trim($_POST['website']));
$catalog_url = addslashes(trim($_POST['catalog_url']));
$skype_link = addslashes(trim($_POST['skype_link']));
$facebook_link = addslashes(trim($_POST['facebook_link']));
$twittter_link = addslashes(trim($_POST['twittter_link']));
$linkedin_link = addslashes(trim($_POST['linkedin_link']));
$instagram_link = addslashes(trim($_POST['instagram_link']));
$youtube_link = addslashes(trim($_POST['youtube_link']));
$pinterest_link = addslashes(trim($_POST['pinterest_link']));
$others_link  = addslashes(trim($_POST['others_link']));
$live_chat_code  = addslashes(trim($_POST['live_chat_code']));
$visitor_vounter_code  = addslashes(trim($_POST['visitor_vounter_code']));
$language_converter_code  = addslashes(trim($_POST['language_converter_code']));
$google_map1  = addslashes(trim($_POST['google_map1']));
$blog_url  = addslashes(trim($_POST['blog_url']));
$designed_dev  = addslashes(trim($_POST['designed_dev']));
$copyright  = addslashes(trim($_POST['copyright']));
$domain_name  = addslashes(trim($_POST['domain_name']));
$out_going_server  = addslashes(trim($_POST['out_going_server']));
$server_email  = addslashes(trim($_POST['server_email']));
$server_email_password  = addslashes(trim($_POST['server_email_password']));

  $query_update="UPDATE users SET name='".$name."',company_name='".$company_name."',email='".$email."',enquiry_email='".$enquiry_email."',mobile='".$mobile."',whatsapp_number='".$whatsapp_number."',customer_support_number='".$customer_support_number."',paytm_number='".$paytm_number."',fax_number='".$fax_number."',working_hours='".$working_hours."',working_hours1='".$working_hours1."',working_hours2='".$working_hours2."',working_hours3='".$working_hours3."',working_hours4='".$working_hours4."',working_hours5='".$working_hours5."',address='".$address."',state='".$state."',city='".$city."',pin_code='".$pin_code."',head_office='".$head_office."',office_number='".$office_number."',google_map='".$google_map."',country='".$country."',website='".$website."',catalog_url='".$catalog_url."',skype_link='".$skype_link."',facebook_link='".$facebook_link."',twittter_link='".$twittter_link."',linkedin_link='".$linkedin_link."',instagram_link='".$instagram_link."',youtube_link='".$youtube_link."',pinterest_link='".$pinterest_link."',others_link='".$others_link."',visitor_vounter_code='".$visitor_vounter_code."',language_converter_code='".$language_converter_code."',blog_url='".$blog_url."',designed_dev='".$designed_dev."',copyright='".$copyright."',domain_name='".$domain_name."',out_going_server='".$out_going_server."',server_email='".$server_email."',server_email_password='".$server_email_password."' WHERE id='$id'"; 



if($sql_update=$conn->prepare($query_update))

{

$sql_update->execute();

if($sql_update->affected_rows>0)

{

unset($_SESSION['user_name']);

$query = "SELECT * FROM users ORDER BY id DESC";

if($sql_query = $conn->query($query))

{

if($sql_query->num_rows>0)

{

$result = $sql_query->fetch_array(MYSQLI_ASSOC);

$user_name = $result['user_name'];

$_SESSION['user_name']=$user_name;

}

}

$response = $pagename." Update Successfully.";

}

else

{

$error = "Please Try Again.";

}

}
if(isset($_FILES['paytm_file']) && $_FILES['paytm_file']['error']==0)
			{

				$array = explode('.', $_FILES['paytm_file']['name']);
				$paytm_fileimage = $array[0];
				$paytm_fileimage1 = $array[1];
				$time =time();
				$paytm_fileimage = $time.$paytm_fileimage;
				$paytm_fileimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($paytm_fileimage)))); 
				$paytm_fileimage = $paytm_fileimage.".".$paytm_fileimage1;  

			    $paytm_fileimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT paytm_file FROM `users` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$paytm_fileimagename =  trim($resultinfo['paytm_file']);
					}
					}
					}
						if($paytm_fileimagename!="")
						{
						$unlkheaderfile = "uploads/paytm_file/".$paytm_fileimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$paytm_filefilename = "uploads/paytm_file/". $paytm_fileimage;
					$mv =move_uploaded_file($_FILES['paytm_file']['tmp_name'],$paytm_filefilename);
					$query_imageup="UPDATE users SET paytm_file='".$paytm_fileimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			}			
}


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
$landline_no = $result['landline_no'];
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
$office_email = $result['office_email'];
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
$live_chat_code = $result['live_chat_code'];
$visitor_vounter_code = $result['visitor_vounter_code'];
$language_converter_code = $result['language_converter_code'];
$google_map1 = $result['google_map1'];
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


<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <title>Dashboard</title>
 
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="dist/js/editor.js"></script>
		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="dist/css/editor.css" type="text/css" rel="stylesheet"/>
    
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('header.php') ?>
  <?php include('left-menu.php') ?>
  
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="col-md-12">
          <div class="main-title">
              <?php 
              if(!empty($response)) 
              echo '<h3 class="h5-headn hegt-96">'.$response.'</h3>';?>
           <h3>Add Contact Detail</h3>
           </div>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                   <div class="col-md-4">
                    <label class="input-text">Name</label>
                  <div class="form-group">
                      <input type="text" class="from-control custom-type" name="name" value="<?php echo $name; ?>" placeholder="Name">
                   </div>
                  </div>
                   <div class="col-md-4">
                    <label class="input-text">Company Name</label>
                  <div class="form-group">
                      <input type="text" class="from-control custom-type" name="company_name" value="<?php echo $company_name; ?>" placeholder="Company Name">
                   </div>
                  </div>
                 
                   <div class="col-md-4">
                    <label class="input-text">Email</label>
                  <div class="form-group">
                      <input type="email" class="from-control custom-type" name="email" value="<?php echo $email; ?>" placeholder="Email id">
                   </div>
                  </div>
                  </div>
                  <div class="row">
                   <div class="col-md-4">
                    <label class="input-text">Enquiry Email</label>
                  <div class="form-group">
                      <input type="email" class="from-control custom-type" name="enquiry_email" value="<?php echo $enquiry_email; ?>" placeholder="Enquiry Email">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">Mobile</label>
                  <div class="form-group">
                      <input type="number" class="from-control custom-type" name="mobile" value="<?php echo $mobile; ?>" placeholder="Mobile No.">
                   </div>
                  </div>
                  <!--<div class="col-md-4">-->
                  <!--  <label class="input-text">Landline No.</label>-->
                  <!--<div class="form-group">-->
                  <!--    <input type="number" class="from-control custom-type" name="landline_no" value="<?php echo $landline_no; ?>" placeholder="landline No.">-->
                  <!-- </div>-->
                  <!--</div>-->
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                    <label class="input-text">Whatsapp Number</label>
                     <div class="form-group">
                      <input type="number" class="from-control custom-type" name="whatsapp_number" value="<?php echo $whatsapp_number; ?>" placeholder="Whatsapp Number">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">Customer Support Number</label>
                     <div class="form-group">
                      <input type="number" class="from-control custom-type" name="customer_support_number" value="<?php echo $customer_support_number; ?>" placeholder="Customer Support Number">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">Address</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="address" value="<?php echo $address; ?>" placeholder="Address">
                   </div>
                  </div>
                  <!--   <div class="col-md-4">-->
                  <!--  <label class="input-text">Paytm Number</label>-->
                  <!--   <div class="form-group">-->
                  <!--    <input type="number" class="from-control custom-type" name="paytm_number" value="<?php echo $paytm_number; ?>" placeholder="Paytm Number">-->
                  <!-- </div>-->
                  <!--</div>-->
                  </div>
                  <!--<div class="row">-->
               
                  <!-- <div class="col-md-4">-->
                  <!--  <label class="input-text">Fax Number</label>-->
                  <!--   <div class="form-group">-->
                  <!--    <input type="number" class="from-control custom-type" name="fax_number" value="<?php echo $fax_number; ?>" placeholder="Fax Number">-->
                  <!-- </div>-->
                  <!--</div>-->
                  <!--</div>-->
                 <!-- <div class="row">-->
                 <!--     <div class="col-md-12">  <label class="input-text">Working Hours</label></div>-->
                 <!--  <div class="col-md-4">-->
                 <!--    <div class="form-group">-->
                 <!--     <input type="text" class="from-control custom-type" name="working_hours" value="<?php echo $working_hours; ?>" placeholder="Working Hours 9:00 a.m - 8:00 p.m">-->
                 <!--   </div>-->
                 <!-- </div>-->
                 <!--<div class="col-md-4">-->
                 <!--    <div class="form-group">-->
                 <!--     <input type="text" class="from-control custom-type" name="working_hours1" value="<?php echo $working_hours1; ?>"  placeholder="Working Hours 9:00 a.m - 8:00 p.m">-->
                 <!--   </div>-->
                 <!-- </div>-->
                 <!--    <div class="col-md-4">-->
                 <!--    <div class="form-group">-->
                 <!--     <input type="text" class="from-control custom-type" name="working_hours2" value="<?php echo $working_hours2; ?>"  placeholder="Working Hours 9:00 a.m - 8:00 p.m">-->
                 <!--   </div>-->
                 <!-- </div>-->
                 <!--      <div class="col-md-4">-->
                 <!--    <div class="form-group">-->
                 <!--     <input type="text" class="from-control custom-type" name="working_hours3" value="<?php echo $working_hours3; ?>" placeholder="Working Hours 9:00 a.m - 8:00 p.m">-->
                 <!--   </div>-->
                 <!-- </div>-->
                 <!--      <div class="col-md-4">-->
                 <!--    <div class="form-group">-->
                 <!--     <input type="text" class="from-control custom-type" name="working_hours4" value="<?php echo $working_hours4; ?>" placeholder="Working Hours 9:00 a.m - 8:00 p.m">-->
                 <!--   </div>-->
                 <!-- </div>-->
                 <!--      <div class="col-md-4">-->
                 <!--    <div class="form-group">-->
                 <!--     <input type="text" class="from-control custom-type" name="working_hours5" value="<?php echo $working_hours5; ?>" placeholder="Working Hours 9:00 a.m - 8:00 p.m">-->
                 <!--   </div>-->
                 <!-- </div>-->
                 <!-- </div>-->
                  <div class="row">
                  
                 <!-- <div class="col-md-3">-->
                 <!--   <label class="input-text">State</label>-->
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="state" value="<?php echo $state; ?>" placeholder="State">-->
                 <!--  </div>-->
                 <!-- </div>-->
                 <!--  <div class="col-md-3">-->
                 <!--   <label class="input-text">City</label>-->
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="city" value="<?php echo $city; ?>" placeholder="City">-->
                 <!--  </div>-->
                 <!-- </div>-->
                 <!--<div class="col-md-3">-->
                 <!--   <label class="input-text">Pin Code</label>-->
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="pin_code" value="<?php echo $pin_code; ?>"  placeholder="Pin Code">-->
                 <!--  </div>-->
                 <!-- </div>      -->
                  </div> 
                     <div class="row">
                  <div class="col-md-6">
                    <label class="input-text">Timings </label>
                   <div class="form-group">
                    <textarea class="ckeditor" class="from-control custom-type" name="head_office" value="<?php echo $head_office; ?>" placeholder="Office Address" rows="3" cols="90"><?php echo $head_office; ?></textarea> 
                   </div>
                  </div>
                  <!--<div class="col-md-3">-->
                  <!--  <label class="input-text">Office Email</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="email" class="from-control custom-type" name="office_email" value="<?php echo $office_email; ?>" placeholder="Office Email">-->
                  <!-- </div>-->
                  <!--</div>-->
                  <!-- <div class="col-md-3">-->
                  <!--  <label class="input-text">Office Number</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="number" class="from-control custom-type" name="office_number" value="<?php echo $office_number; ?>" placeholder="Office Number">-->
                  <!-- </div>-->
                  <!--</div>-->
                 <div class="col-md-3">
                    <label class="input-text">Google Map</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="google_map" value="<?php echo $google_map; ?>" placeholder="Business office map">
                   </div>
                  </div>      
                  </div> 
                   <div class="row">
                  <div class="col-md-4">
                    <label class="input-text">Whats App Message </label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="country" value="<?php echo $country; ?>" placeholder="Country">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">Website</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="website" value="<?php echo $website; ?>" placeholder="Website">
                   </div>
                  </div>
                  <!--  <div class="col-md-4">-->
                  <!--  <label class="input-text">Catalog URL</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="text" class="from-control custom-type" name="catalog_url" value="<?php echo $catalog_url; ?>" placeholder="Catalog URL">-->
                  <!-- </div>-->
                  <!--</div>-->
                  <div class="col-md-4">
                    <label class="input-text">Established Year</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="skype_link" value="<?php echo $skype_link; ?>" placeholder="SKYPE Link">
                   </div>
                  </div>
                 <div class="col-md-4">
                    <label class="input-text">Facebook Link</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="facebook_link" value="<?php echo $facebook_link; ?>" placeholder="Facebook Link">
                   </div>
                  </div>
                        <div class="col-md-4">
                    <label class="input-text">Twitter Link</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="twittter_link" value="<?php echo $twittter_link; ?>" placeholder="Twitter Link">
                   </div>
                  </div>
                        <div class="col-md-4">
                    <label class="input-text">Linkedin Link</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="linkedin_link" value="<?php echo $linkedin_link; ?>" placeholder="Linkedin Link">
                   </div>
                  </div>
                    <div class="col-md-4">
                    <label class="input-text">Instagram Link</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="instagram_link" value="<?php echo $instagram_link; ?>" placeholder="Instagram Link">
                   </div>
                  </div>
                 <div class="col-md-4">
                    <label class="input-text">YouTube Link</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="youtube_link" value="<?php echo $youtube_link; ?>" placeholder="YouTube Link">
                   </div>
                  </div>  
                 <div class="col-md-4">
                    <label class="input-text">Pinterest Link</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="pinterest_link" value="<?php echo $pinterest_link; ?>" placeholder="Pinterest Link">
                   </div>
                  </div>  
                  <!--<div class="col-md-4">-->
                  <!--  <label class="input-text">Others Link</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="text" class="from-control custom-type" name="others_link" value="<?php echo $others_link; ?>" placeholder="Others Link">-->
                  <!-- </div>-->
                  <!--</div> -->
                  <!--  <div class="col-md-4">-->
                  <!--  <label class="input-text">Live Chat Code</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="text" class="from-control custom-type" name="live_chat_code" value="<?php echo $live_chat_code; ?>" placeholder="Live Chat Code">-->
                  <!-- </div>-->
                  <!--</div>  -->
                  <!--  <div class="col-md-4">-->
                  <!--  <label class="input-text">Visitor Vounter Code</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="text" class="from-control custom-type" name="visitor_vounter_code" value="<?php echo $visitor_vounter_code; ?>" placeholder="Visitor Vounter Code">-->
                  <!-- </div>-->
                  <!--</div>  -->
                  <!--  <div class="col-md-4">-->
                  <!--  <label class="input-text">Language Converter Code</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="text" class="from-control custom-type" name="language_converter_code" value="<?php echo $language_converter_code; ?>" placeholder="Language Converter Code">-->
                  <!-- </div>-->
                  <!--</div>  -->
                  <!--  <div class="col-md-4">-->
                  <!--  <label class="input-text">Google Map</label>-->
                  <!-- <div class="form-group">-->
                  <!--  <input type="text" class="from-control custom-type" name="google_map1" value="<?php echo $google_map1; ?>" placeholder="Google Map">-->
                  <!-- </div>-->
                  <!--</div>-->
                 <!--<div class="col-md-4">-->
                 <!--   <label class="input-text">Blog Url</label>-->
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="blog_url" value="<?php echo $blog_url; ?>" placeholder="Blog Url">-->
                 <!--  </div>-->
                 <!-- </div>-->
                 <!--     <div class="col-md-4">-->
                 <!--   <label class="input-text">Designed & Developed By</label>-->
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="designed_dev" value="<?php echo $designed_dev; ?>" placeholder="Designed & Developed By">-->
                 <!--  </div>-->
                 <!-- </div>-->
                         <div class="col-md-4">
                    <label class="input-text">Copyright © [Reserved By]</label>
                   <div class="form-group">
                    <input type="text" class="from-control custom-type" name="copyright" value="<?php echo $copyright; ?>" placeholder="Copyright © [Reserved By]">
                   </div>
                  </div>
                
                 <!-- <div class="row">-->
                 <!--     <div class="col-md-12"><label class="input-text">Server Configuration </label></div>-->
                 <!-- <div class="col-md-3">-->
                    
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="domain_name" value="<?php echo $domain_name; ?>" placeholder="Domain Name [www.mydomain.com]">-->
                 <!--  </div>-->
                 <!-- </div>-->
                 <!-- <div class="col-md-3">-->
                   
                 <!--  <div class="form-group">-->
                 <!--   <input type="email" class="from-control custom-type" name="out_going_server" value="<?php echo $out_going_server; ?>" placeholder="Out Going Server [mail.mydomain.com]">-->
                 <!--  </div>-->
                 <!-- </div>-->
                 <!--  <div class="col-md-3">-->
                
                 <!--  <div class="form-group">-->
                 <!--   <input type="number" class="from-control custom-type" name="server_email" value="<?php echo $server_email; ?>" placeholder="Server Email [contact@mydomain.com]">-->
                 <!--  </div>-->
                 <!-- </div>-->
                 <!--<div class="col-md-3">-->
                    
                 <!--  <div class="form-group">-->
                 <!--   <input type="text" class="from-control custom-type" name="server_email_password" value="<?php echo $server_email_password; ?>" placeholder="Server Email Password [We#2$FrEE%&]">-->
                 <!--  </div>-->
                 <!-- </div> -->
                        <div class="col-md-12">
                 <button type="submit" name="submit" value="update" class="btn btn-submit">Submit</button>     
                  </div>
             
                  </div> 
                
              </form>
              </div>
          </div>
        
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="#">Dashboard</a>.</strong> All rights
    reserved.
  </footer>
</div>
	
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>


</body>
</html>
