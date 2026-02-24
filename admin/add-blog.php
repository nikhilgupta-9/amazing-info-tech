<?php 

include('config/function.php');
// include('config/conn.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

/* set variable */
$pagename = "Blog";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$blog_heading = "";
$blog_description = "";
$blog_img = "";
$blog_img_alt = "";
$blog_tags = "";
$blog_posted_by = "";
$page_title = "";
$page_keyword = "";
$page_description = "";
$show_homepage = "";
$is_active = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	
	$blog_heading = addslashes(trim($_POST['blog_heading']));
	$blog_url = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($blog_heading))));
	$blog_description = addslashes(trim($_POST['blog_description']));
	$blog_img_alt = addslashes(trim($_POST['blog_img_alt']));
	$blog_tags = addslashes(trim($_POST['blog_tags']));
	$blog_posted_by = addslashes(trim($_POST['blog_posted_by']));
	$page_title = addslashes(trim($_POST['page_title']));
	$page_keyword = addslashes(trim($_POST['page_keyword']));
	$page_description = addslashes(trim($_POST['page_description']));
	$show_homepage = addslashes(trim($_POST['show_homepage']));
	if(!empty($_POST['is_active'])) { $is_active=1; } else{ $is_active=0; }
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM tbl_blog WHERE blog_heading='".$blog_heading."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Heading is already exist, please try another.";
		}
		else
		{
			if($id!="")
			{
				$query_update="UPDATE tbl_blog SET blog_heading='".$blog_heading."',blog_url='".$blog_url."',blog_description='".$blog_description."',blog_img_alt='".$blog_img_alt."',blog_tags='".$blog_tags."',blog_posted_by='".$blog_posted_by."',page_title='".$page_title."',page_keyword='".$page_keyword."',page_description='".$page_description."',show_homepage='".$show_homepage."',is_active='".$is_active."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$sess_msg = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO tbl_blog SET blog_heading='".$blog_heading."',blog_url='".$blog_url."',blog_description='".$blog_description."',blog_img_alt='".$blog_img_alt."',blog_tags='".$blog_tags."',blog_posted_by='".$blog_posted_by."',page_title='".$page_title."',page_keyword='".$page_keyword."',page_description='".$page_description."',show_homepage='".$show_homepage."',is_active='".$is_active."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}
			}
			if(isset($_FILES['blog_img']) && $_FILES['blog_img']['error']==0)
			{

				$array = explode('.', $_FILES['blog_img']['name']);
				$galleryimage = $array[0];
				$galleryimage1 = $array[1];
				$time =time();
				$galleryimage = $time.$galleryimage;
				$galleryimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($galleryimage)))); 
				$galleryimage = $galleryimage.".".$galleryimage1;  

			    $galleryimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT blog_img FROM `tbl_blog` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$galleryimagename =  trim($resultinfo['blog_img']);
					}
					}
					}
						if($galleryimagename!="")
						{
						$unlkheaderfile = "uploads/blog/".$galleryimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$galleryfilename = "uploads/blog/". $galleryimage;
					$mv =move_uploaded_file($_FILES['blog_img']['tmp_name'],$galleryfilename);
					$query_imageup="UPDATE tbl_blog SET blog_img='".$galleryimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			echo "<script>document.location.href='view-blog.php?msg=".$sess_msg."';</script>";
			exit;
		}
	}
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM tbl_blog WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			
			$blog_heading = stripslashes($result['blog_heading']);
			$blog_url = stripslashes($result['blog_url']);
			$blog_description = stripslashes($result['blog_description']);
			$blog_img_alt = stripslashes($result['blog_img_alt']);
			$blog_tags = stripslashes($result['blog_tags']);
			$blog_posted_by = stripslashes($result['blog_posted_by']);
			$page_title = stripslashes($result['page_title']);
			$page_keyword = stripslashes($result['page_keyword']);
			$page_description = stripslashes($result['page_description']);
			$show_homepage = stripslashes($result['show_homepage']);
			$blog_img = $result['blog_img'];
			$is_active = $result['is_active'];
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='view-blog.php';</script>";
			exit;
		}
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
	   <?php if($msg!="") { ?><h5 class="h5-headn" style="color:red;"><?php echo $msg; ?></h5><?php } else { ?>
          <div class="main-title">
           <h3>Add Blog</h3>
           </div>
		   <?php } ?>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form method="post" enctype="multipart/form-data">
              <div class="row">
               
               <div class="col-md-4">
                    <label class="input-text">Heading</label>
                  <div class="form-group">
                      <input type="text" name="blog_heading" value="<?php echo $blog_heading; ?>" class="from-control custom-type">
                   </div>
                  </div>

                   <div class="col-md-4">
                    <label class="input-text">Url</label>
                  <div class="form-group">
                      <input type="text" name="blog_url" value="<?php echo $blog_url; ?>" class="from-control custom-type" readonly>
                   </div>
                  </div>

                     <div class="col-md-12">
                  <label class="input-text">Blog Description</label>
				  <div class="form-group">
                      <textarea name="blog_description" id="blog_description" class="ckeditor" class="from-control custom-type" placeholder="Page Description" rows="10" cols="180"><?php echo $blog_description;?></textarea>
                   </div>
                 
               
                 </div>
                 
                  <div class="col-md-4">
                    <label class="input-text">Image</label>
                    <div class="form-group">
					<?php if($blog_img!="") { ?>
					<img src="uploads/blog/<?php echo $result['blog_img']?>" height="100" width="120" title="<?php echo $blog_heading;?> Image">
					<?php } ?>
                      <input type="file" name="blog_img" value="<?php echo $result['blog_img']?>" class="from-control custom-type">
                   </div>
                  </div>

                    <div class="col-md-4">
                    <label class="input-text">Image Alt Tag</label>
                  <div class="form-group">
                      <input type="text" name="blog_img_alt" value="<?php echo $blog_img_alt; ?>" class="from-control custom-type">
                   </div>
                  </div>

                    <div class="col-md-4">
                    <label class="input-text">Blog Tags</label>
                  <div class="form-group">
                      <input type="text" name="blog_tags" value="<?php echo $blog_tags; ?>" class="from-control custom-type">
                   </div>
                  </div>


                  <div class="col-md-4">
                    <label class="input-text">Blog Posted By</label>
                  <div class="form-group">
                      <input type="text" name="blog_posted_by" value="<?php echo $blog_posted_by; ?>" class="from-control custom-type">
                   </div>
                  </div>


                  <div class="col-md-4">
                    <label class="input-text">Page Title</label>
                  <div class="form-group">
                      <input type="text" name="page_title" value="<?php echo $page_title; ?>" class="from-control custom-type">
                   </div>
                  </div>


                      <div class="col-md-4">
                    <label class="input-text">Page Keyword</label>
                  <div class="form-group">
                      <input type="text" name="page_keyword" value="<?php echo $page_keyword; ?>" class="from-control custom-type">
                   </div>
                  </div>


                    <div class="col-md-4">
                    <label class="input-text">Page Description</label>
                  <div class="form-group">
                      <input type="text" name="page_description" value="<?php echo $page_description; ?>" class="from-control custom-type">
                   </div>
                  </div>
                  
                    <div class="col-md-4">
                    <label class="input-text">Show on Homepage</label>
                    <div class="form-group">
                    <select name="show_homepage" class="form-control custom-type">
                    <option value="" <?php if($show_homepage=="in_stock"){echo "selected"; } ?>>select an option</option>
                    <option value="yes" <?php if($show_homepage=="yes"){echo "selected"; } ?>>Yes</option>
                    <option value="no" <?php if($show_homepage=="no"){echo "selected"; } ?>>No</option>
                    </select>
                    </div>
                    </div>


				  <div class="col-md-4">
                  <label class="input-text">Status</label>
                <br>
                 <label class="switch">
				 <input type="checkbox" class="form-control" name="is_active[]" id="status" value="1" <?php if($is_active==  1) { echo "checked"; } ?>/>
				<div id="status_status"></div>
                  
                </label>
                  </div>
                  </div>
                  <div class="row">
               
                  <div class="col-md-12">
                                            
                 <button type="submit" name="submit" value="add" class="btn btn-submit">Add</button>  
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
	

<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<script>
$(function(){
$("#status").toggleSwitch();
$("#myonoffswitch2").toggleSwitch();
});
</script>


<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
</body>
</html>
