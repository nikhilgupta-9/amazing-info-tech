<?php 
include('config/function.php');
if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

/* set variable */
$pagename = "menu";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$page_name = "";	
$page_url = "";
$page_show_in  = "";
$page_category  = "";
$page_type  = "";
$video  = "";
$page_title  = "";
$page_slogan  = "";
$page_keyword  = "";
$status = "";
$message  = "";
$himage  = "";
$fvicon  = "";
$actimg_width  = "";
$actimg_height  = "";
$zoomimg_width  = "";
$zoomimg_height  = "";
$normalimg_width  = "";
$normalimg_height  = "";
$smallimg_width  = "";
$smallimg_height  = "";
$thumbimg_width  = "";
$thumbimg_height  = "";
$up_image  = "";
$up_pdf  = "";
$page_description  = "";
$sort_description  = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	
	
	$page_name = addslashes(ucwords(trim($_POST['page_name'])));
	$page_url = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($page_name))));
	$page_show_in = $_POST['page_show_in'];
	$page_category = addslashes($_POST['page_category']);
	$page_type = addslashes($_POST['page_type']);
	$page_title = addslashes($_POST['page_title']);
	$page_slogan = addslashes($_POST['page_slogan']);
	$page_keyword = addslashes($_POST['page_keyword']);
	$message = addslashes($_POST['message']);
	$actimg_width = addslashes($_POST['actimg_width']);
	$actimg_height = addslashes($_POST['actimg_height']);
	$zoomimg_width = addslashes($_POST['zoomimg_width']);
	$zoomimg_height = addslashes($_POST['zoomimg_height']);
	$normalimg_width = addslashes($_POST['normalimg_width']);
	$normalimg_height = addslashes($_POST['normalimg_height']);
	$smallimg_width = addslashes($_POST['smallimg_width']);
	$smallimg_height = addslashes($_POST['smallimg_height']);
	$thumbimg_width = addslashes($_POST['thumbimg_width']);
	$thumbimg_height = addslashes($_POST['thumbimg_height']);
	$page_description = addslashes($_POST['page_description']); 
	$sort_description = addslashes($_POST['sort_description']);
	
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0; }
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM cms_menu WHERE page_name='".$page_name."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Page Name is already exist, please try another.";
		}
		else
		{
			if($id!="")
			{
			$query_update="UPDATE cms_menu SET page_name='".$page_name."',page_url='".$page_url."',page_show_in='".$page_show_in."',page_category='".$page_category."',status='".$status."',page_type='".$page_type."',page_title='".$page_title."',page_slogan='".$page_slogan."',page_keyword='".$page_keyword."',message='".$message."',actimg_width='".$actimg_width."',actimg_height='".$actimg_height."',zoomimg_width='".$zoomimg_width."',zoomimg_height='".$zoomimg_height."',normalimg_width='".$normalimg_width."',normalimg_height='".$normalimg_height."',smallimg_width='".$smallimg_width."',smallimg_height='".$smallimg_height."',thumbimg_width='".$thumbimg_width."',thumbimg_height='".$thumbimg_height."',page_description='".$page_description."',sort_description='".$sort_description."' WHERE id='".$id."'";  
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$sess_msg = $pagename." Update Successfully.";	
				}
			}
			else
			{
				 $query_insert="INSERT INTO cms_menu SET page_name='".$page_name."',page_url='".$page_url."',page_show_in='".$page_show_in."',page_category='".$page_category."',status='".$status."',page_type='".$page_type."',page_title='".$page_title."',page_slogan='".$page_slogan."',page_keyword='".$page_keyword."',message='".$message."',actimg_width='".$actimg_width."',actimg_height='".$actimg_height."',zoomimg_width='".$zoomimg_width."',zoomimg_height='".$zoomimg_height."',normalimg_width='".$normalimg_width."',normalimg_height='".$normalimg_height."',smallimg_width='".$smallimg_width."',smallimg_height='".$smallimg_height."',thumbimg_width='".$thumbimg_width."',thumbimg_height='".$thumbimg_height."',sort_description='".$sort_description."',page_description='".$page_description."'";
				
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}
			}
			
			if(isset($_FILES['video']) && $_FILES['video']['error']==0)
			{

				$array = explode('.', $_FILES['video']['name']);
				$videoimage = $array[0];
				$videoimage1 = $array[1];
				$time =time();
				$videoimage = $time.$videoimage;
				$videoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($videoimage)))); 
				$videoimage = $videoimage.".".$videoimage1;  

			    $videoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT video FROM `cms_menu` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$videoimagename =  trim($resultinfo['video']);
					}
					}
					}
						if($videoimagename!="")
						{
						$unlkheaderfile = "uploads/video/".$videoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$videofilename = "uploads/video/". $videoimage;
					$mv =move_uploaded_file($_FILES['video']['tmp_name'],$videofilename);
					$query_imageup="UPDATE cms_menu SET video='".$videoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			if(isset($_FILES['himage']) && $_FILES['himage']['error']==0)
			{

				$array = explode('.', $_FILES['himage']['name']);
				$himageimage = $array[0];
				$himageimage1 = $array[1];
				$time =time();
				$himageimage = $time.$himageimage;
				$himageimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($himageimage)))); 
				$himageimage = $himageimage.".".$himageimage1;  

			    $himageimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT himage FROM `cms_menu` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$himageimagename =  trim($resultinfo['himage']);
					}
					}
					}
						if($himageimagename!="")
						{
						$unlkheaderfile = "uploads/himage/".$himageimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$himagefilename = "uploads/himage/". $himageimage;
					$mv =move_uploaded_file($_FILES['himage']['tmp_name'],$himagefilename);
					$query_imageup="UPDATE cms_menu SET himage='".$himageimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			if(isset($_FILES['fvicon']) && $_FILES['fvicon']['error']==0)
			{

				$array = explode('.', $_FILES['fvicon']['name']);
				$fviconimage = $array[0];
				$fviconimage1 = $array[1];
				$time =time();
				$fviconimage = $time.$fviconimage;
				$fviconimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($fviconimage)))); 
				$fviconimage = $fviconimage.".".$fviconimage1;  

			    $fviconimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT fvicon FROM `cms_menu` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$fviconimagename =  trim($resultinfo['fvicon']);
					}
					}
					}
						if($fviconimagename!="")
						{
						$unlkheaderfile = "uploads/fvicon/".$fviconimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$fviconfilename = "uploads/fvicon/". $fviconimage;
					$mv =move_uploaded_file($_FILES['fvicon']['tmp_name'],$fviconfilename);
					$query_imageup="UPDATE cms_menu SET fvicon='".$fviconimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			if(isset($_FILES['up_image']) && $_FILES['up_image']['error']==0)
			{

				$array = explode('.', $_FILES['up_image']['name']);
				$up_imageimage = $array[0];
				$up_imageimage1 = $array[1];
				$time =time();
				$up_imageimage = $time.$up_imageimage;
				$up_imageimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($up_imageimage)))); 
				$up_imageimage = $up_imageimage.".".$up_imageimage1;  

			    $up_imageimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT up_image FROM `cms_menu` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$up_imageimagename =  trim($resultinfo['up_image']);
					}
					}
					}
						if($up_imageimagename!="")
						{
						$unlkheaderfile = "uploads/up_image/".$up_imageimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$up_imagefilename = "uploads/up_image/". $up_imageimage;
					$mv =move_uploaded_file($_FILES['up_image']['tmp_name'],$up_imagefilename);
					$query_imageup="UPDATE cms_menu SET up_image='".$up_imageimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			if(isset($_FILES['up_pdf']) && $_FILES['up_pdf']['error']==0)
			{

				$array = explode('.', $_FILES['up_pdf']['name']);
				$up_pdfimage = $array[0];
				$up_pdfimage1 = $array[1];
				$time =time();
				$up_pdfimage = $time.$up_pdfimage;
				$up_pdfimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($up_pdfimage)))); 
				$up_pdfimage = $up_pdfimage.".".$up_pdfimage1;  

			    $up_pdfimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT up_pdf FROM `cms_menu` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$up_pdfimagename =  trim($resultinfo['up_pdf']);
					}
					}
					}
						if($up_pdfimagename!="")
						{
						$unlkheaderfile = "uploads/up_pdf/".$up_pdfimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$up_pdffilename = "uploads/up_pdf/". $up_pdfimage;
					$mv =move_uploaded_file($_FILES['up_pdf']['tmp_name'],$up_pdffilename);
					$query_imageup="UPDATE cms_menu SET up_pdf='".$up_pdfimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			
			echo "<script>document.location.href='view-menu.php?msg=".$sess_msg."';</script>";
			exit;
		}
	}
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM cms_menu WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			
			$page_name = stripslashes($result['page_name']);
			$page_url = stripslashes($result['page_url']);
			$page_show_in = $result['page_show_in'];
			$page_category = stripslashes($result['page_category']);
			$page_type = stripslashes($result['page_type']);
			$video = $result['video'];
			$page_title = stripslashes($result['page_title']);
			$page_slogan = stripslashes($result['page_slogan']);
			$page_keyword = stripslashes($result['page_keyword']);
			$status = $result['status'];
			$message = stripslashes($result['message']);
			$himage = $result['himage'];
			$fvicon = $result['fvicon'];
			$actimg_width = $result['actimg_width'];
			$actimg_height = $result['actimg_height'];
			$zoomimg_width = $result['zoomimg_width'];
			$zoomimg_height = $result['zoomimg_height'];
			$normalimg_width = $result['normalimg_width'];
			$normalimg_height = $result['normalimg_height'];
			$smallimg_width = $result['smallimg_width'];
			$smallimg_height = $result['smallimg_height'];
			$thumbimg_width = $result['thumbimg_width'];
			$thumbimg_height = $result['thumbimg_height'];
			$up_image = $result['up_image'];
			$up_pdf = $result['up_pdf'];
			$sort_description = stripslashes($result['sort_description']);
			$page_description = stripslashes($result['page_description']);
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='view-menu.php';</script>";
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
          <div class="main-title">
           <h3>Add Menu</h3>
           </div>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form action="" method="post" enctype="multipart/form-data" >
              <div class="row">
               <div class="col-md-4">
                <label class="input-text">Page Name</label>
                  <div class="form-group">
                      <input type="text" name="page_name" value="<?php echo $page_name; ?>" required class="from-control custom-type">
                   </div>
                  </div>
                 <div class="col-md-4">
                  <label class="input-text">Page Url</label>
                   <div class="form-group">
                      <input type="text" name="page_url" value="<?php echo $page_url; ?>" class="from-control custom-type" readonly style="cursor: not-allowed; opacity: 1;">
                   </div>
                  </div>
                  <div class="col-md-4 mt-5">
                   <button type="submit" name="submit" value="add" class="btn btn-submit">Create</button>   
                  </div>
                  </div>
                  <div class="row">
                   <div class="col-md-3">
                     <label class="input-text">Page Show in</label>
                   <div class="form-group">
                       <select name="page_show_in" required class="from-control custom-type">
                        <option <?php if($page_show_in==""){echo "selected"; } ?> value="">select an option</option>
                        <option <?php if($page_show_in=="header_footer"){echo "selected"; } ?> value="header_footer">Header & Footer </option>
                        <option <?php if($page_show_in=="header_top"){echo "selected"; } ?> value="header_top">Header & Top  </option>
                        <option <?php if($page_show_in=="header"){echo "selected"; } ?> value="header">Header</option>
                        <option <?php if($page_show_in=="footer"){echo "selected"; } ?> value="footer">footer</option>
                        <option <?php if($page_show_in=="top"){echo "selected"; } ?> value="top">Top</option>
                        <option <?php if($page_show_in=="inner_page"){echo "selected"; } ?> value="inner_page">Inner page</option>
                        <option <?php if($page_show_in=="side_menu"){echo "selected"; } ?> value="side_menu">Side Menu</option>
                       </select>
                   </div>
                  </div>   
                   <div class="col-md-3">
                     <label class="input-text">Page is Category?</label>
                   <div class="form-group">
                       <select name="page_category" required class="from-control custom-type">
                        <option <?php if($page_category==""){echo "selected"; } ?> value="">select an option</option>
                        <option <?php if($page_category=="yes"){echo "selected"; } ?> value="yes">Yes</option>
                        <option <?php if($page_category=="no"){echo "selected"; } ?> value="no">No</option>
                       
                       </select>
                   </div>
                  </div>   
                    <div class="col-md-3">
                     <label class="input-text">Page type?</label>
                      <div class="form-group">
                       <select name="page_type" required class="from-control custom-type">
                        <option <?php if($page_type==""){echo "selected"; } ?> value="">select an option</option>
                        <option <?php if($page_type=="cms"){echo "selected"; } ?> value="cms">CMS</option>
                        <option <?php if($page_type=="category"){echo "selected"; } ?> value="category">Category</option>
                       </select>
                   </div>
                  </div> 
                      
                <div class="col-md-3">
                <label class="input-text">Upload Video file</label>
                  <div class="form-group">
				     <?php if($video!="") { ?>
					<video width="200" controls>
  <source src="uploads/video/<?php echo $video;?>" type="video/mp4" height="100" width="120" >
  <source src="uploads/video/<?php echo $video;?>" type="video/ogg" height="100" width="120" >
  Your browser does not support HTML5 video.
</video>      
					<?php } ?>
                      <input type="file" name="video" value="<?php echo $video;?>"  class="from-control custom-type">
                   </div>
                  </div> 
                 <div class="col-md-3">
                <label class="input-text">Page Title</label>
                  <div class="form-group">
                      <input type="text" name="page_title" value="<?php echo $page_title;?>" class="from-control custom-type" placeholder="Page Title">
                   </div>
                  </div> 
                  
                <div class="col-md-3">
                <label class="input-text">Page Canonical</label>
                  <div class="form-group">
                      <input type="text" name="page_keyword" value="<?php echo $page_keyword;?>" class="from-control custom-type" placeholder="Page Keyword">
                   </div>
                  </div> 
                      <div class="col-md-3">
                   <label class="input-text">Status</label>
                      <br>
                 <label class="switch">
				 <input type="checkbox" class="form-control" required name="status[]" id="status" value="1" <?php if($status==1) { echo "checked"; } ?>/>
				<div id="status_status"></div>
                  
                   </label>
                  </div>
                 <div class="col-md-12">
                 <label class="input-text">Page Meta Description</label>
                  <div class="form-group">
                      <textarea name="message" class="from-control custom-type" placeholder="Page Meta Description" rows="5" cols="5"><?php echo $message;?></textarea>
                   </div>
                  </div> 
                <div class="col-md-6">
                <label class="input-text">Upload Header Image</label>
                  <div class="form-group">
				    <?php if($himage!="") { ?>
					<img src="uploads/himage/<?php echo $himage;?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="himage" value="<?php echo $himage;?>" class="form-control custom-type" >
                   </div>
                  </div>   
                <div class="col-md-6">
                <label class="input-text">Upload Icon Image</label>
                  <div class="form-group">
				     <?php if($fvicon!="") { ?>
					<img src="uploads/fvicon/<?php echo $fvicon;?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="fvicon" value="<?php echo $fvicon;?>" class="form-control custom-type" >
                   </div>
                  </div> 
                  </div>
                   <div class="row">
                      <div class="col-md-2">
                          <label class="input-text">Actual Image : </label>
                       </div>
                      <div class="col-md-10 "> 
               
          <input type="text" size="4" placeholder="Width" name="actimg_width" value="<?php echo $actimg_width;?>">
           <input type="text" size="4" placeholder="Height" name="actimg_height" value="<?php echo $actimg_height;?>">
         
          <span style="margin-left:10px;"></span>Zoom Image :
            <input type="text" size="4" placeholder="Width" name="zoomimg_width" value="<?php echo $zoomimg_width;?>">
          <input type="text" size="4" placeholder="Height" name="zoomimg_height" value="<?php echo $zoomimg_height;?>">
        
          <span style="margin-left:10px;"></span>Normal Image :
            <input type="text" size="4" placeholder="Width" name="normalimg_width" value="<?php echo $normalimg_width;?>">
          <input type="text" size="4" placeholder="Height" name="normalimg_height" value="<?php echo $normalimg_height;?>">
        
          <span style="margin-left:10px;"></span>Small Image :
           <input type="text" size="4" placeholder="Width" name="smallimg_width" value="<?php echo $smallimg_width;?>">
          <input type="text" size="4" placeholder="Height" name="smallimg_height" value="<?php echo $smallimg_height;?>">
         
          <span style="margin-left:10px;"></span>Thumb Image :
          <input type="text" size="4" placeholder="Width" name="thumbimg_width" value="<?php echo $thumbimg_width;?>">
          <input type="text" size="4" placeholder="Height" name="thumbimg_height" value="<?php echo $thumbimg_height;?>">
                       </div>
                      </div>
                  <div class="row">
                    <div class="col-md-6">
                <label class="input-text">Upload  Image</label>
                  <div class="form-group">
				   <?php if($up_image!="") { ?>
					<img src="uploads/up_image/<?php echo $up_image;?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="up_image" value="<?php echo $up_image;?>"  class="form-control custom-type" >
                   </div>
                  </div>   
                <div class="col-md-6">
                <label class="input-text">Upload PDF</label>
                  <div class="form-group">
				  <?php if($up_pdf!="") { ?>
					<img src="uploads/up_pdf/<?php echo $up_pdf;?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="up_pdf" value="<?php echo $up_pdf;?>" class="form-control custom-type">
                   </div>
                  </div> 
                <div class="col-md-12">
                 <label class="input-text">Short Description</label>
                  <div class="form-group">
                      <textarea name="sort_description" class="ckeditor" class="from-control custom-type" placeholder="Short Description" rows="5" cols="5"><?php echo $sort_description;?></textarea>
                   </div>
                  </div>  
                      
                 <div class="col-md-12">
                  <label class="input-text">Page Description</label>
				   <div class="form-group">
                      <textarea name="page_description" id="page_description" class="ckeditor" class="from-control custom-type" placeholder="Page Description" rows="10" cols="180"><?php echo $page_description;?></textarea>
                   </div>                 
                  </div> 

                <div class="col-md-12">
                <label class="input-text">Page Slogan</label>
                 <div class="form-group">
                      <textarea name="page_slogan" id="page_slogan" class="ckeditor" class="from-control custom-type" placeholder="Inner Page Description" rows="10" cols="180"><?php echo $page_slogan;?></textarea>
                   </div>
                  
                  </div> 
                                  
                  <div class="col-md-12">
                   <button type="submit" name="submit" value="add" class="btn btn-submit">SUBMIT</button>     
                                            
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
    <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="#">Dashboard</a>.</strong> All rights
    reserved.
  </footer>
</div>
	
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<script>
$(function(){
$("#status").toggleSwitch();
$("#myonoffswitch2").toggleSwitch();
});
</script>
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script src="plugins/ckeditor/ckeditor.js"></script>

</body>
</html>
