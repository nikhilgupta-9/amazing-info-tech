<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

/* set variable */
$pagename = "Logo";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$title = "";
$image = "";
$logo_title = "";
$status = "";
$logo_directory = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'logo';
$logo_asset_folders = array(
	'fav_icon_image' => 'fav_icon_image',
	'left_logo' => 'left_logo',
	'center_logo' => 'center_logo',
	'right_logo' => 'right_logo',
	'footer_logo' => 'footer_logo',
	'iso_logo' => 'iso_logo'
);

function save_logo_asset($field, $column, $folder, $id, $conn)
{
	if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
		return;
	}

	$directory = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $folder;
	if (!is_dir($directory)) {
		mkdir($directory, 0755, true);
	}

	$extension = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
	$base_name = pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME);
	$base_name = preg_replace('/[^a-zA-Z0-9-]+/', '-', $base_name);
	$file_name = time() . '-' . trim($base_name, '-') . ($extension ? '.' . $extension : '');

	$old_statement = $conn->prepare("SELECT `$column` FROM logo WHERE id = ?");
	if ($old_statement) {
		$old_statement->bind_param('i', $id);
		$old_statement->execute();
		$old_result = $old_statement->get_result();
		if ($old_result && ($old_row = $old_result->fetch_assoc()) && !empty($old_row[$column])) {
			$old_path = $directory . DIRECTORY_SEPARATOR . $old_row[$column];
			if (is_file($old_path)) {
				unlink($old_path);
			}
		}
	}

	$destination = $directory . DIRECTORY_SEPARATOR . $file_name;
	if (move_uploaded_file($_FILES[$field]['tmp_name'], $destination)) {
		$update_statement = $conn->prepare("UPDATE logo SET `$column` = ? WHERE id = ?");
		if ($update_statement) {
			$update_statement->bind_param('si', $file_name, $id);
			$update_statement->execute();
		}
	}
}

/* get id */

	$id = '1';


if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	$logo_title = addslashes(ucwords(trim($_POST['logo_title'])));
	
	/* check title in database */

			
				$query_update="UPDATE logo SET logo_title='".$logo_title."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$sess_msg = $pagename." Update Successfully.";		
				}
			
			if(isset($_FILES['logo_image']) && $_FILES['logo_image']['error']==0)
			{
				if (!is_dir($logo_directory)) {
					mkdir($logo_directory, 0755, true);
				}
				$logo_extension = strtolower(pathinfo($_FILES['logo_image']['name'], PATHINFO_EXTENSION));
				$logoimage = pathinfo($_FILES['logo_image']['name'], PATHINFO_FILENAME);
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage . '.' . $logo_extension;

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT logo_image FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['logo_image']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = $logo_directory . '/' . $logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = $logo_directory . '/' . $logoimage;
					$mv =move_uploaded_file($_FILES['logo_image']['tmp_name'],$logofilename);
					if ($mv) {
						$query_imageup="UPDATE logo SET logo_image='".$logoimage."' WHERE id='".$id."'";
						if($sql_imageup=$conn->prepare($query_imageup))
						$sql_imageup->execute();
					}
			} 

			foreach ($logo_asset_folders as $field => $folder) {
				save_logo_asset($field, $field, $folder, $id, $conn);
			}

			if(false && isset($_FILES['fav_icon_image']) && $_FILES['fav_icon_image']['error']==0)
			{

				$array = explode('.', $_FILES['fav_icon_image']['name']);
				$logoimage = $array[0];
				$logoimage1 = $array[1];
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage.".".$logoimage1;  

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT fav_icon_image FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['fav_icon_image']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = "uploads/fav_icon_image/".$logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = "uploads/fav_icon_image/". $logoimage;
					$mv =move_uploaded_file($_FILES['fav_icon_image']['tmp_name'],$logofilename);
					$query_imageup="UPDATE logo SET fav_icon_image='".$logoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			
			if(false && isset($_FILES['left_logo']) && $_FILES['left_logo']['error']==0)
			{

				$array = explode('.', $_FILES['left_logo']['name']);
				$logoimage = $array[0];
				$logoimage1 = $array[1];
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage.".".$logoimage1;  

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT left_logo FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['left_logo']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = "uploads/left_logo/".$logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = "uploads/left_logo/". $logoimage;
					$mv =move_uploaded_file($_FILES['left_logo']['tmp_name'],$logofilename);
					$query_imageup="UPDATE logo SET left_logo='".$logoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			
			if(false && isset($_FILES['center_logo']) && $_FILES['center_logo']['error']==0)
			{

				$array = explode('.', $_FILES['center_logo']['name']);
				$logoimage = $array[0];
				$logoimage1 = $array[1];
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage.".".$logoimage1;  

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT center_logo FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['center_logo']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = "uploads/center_logo/".$logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = "uploads/center_logo/". $logoimage;
					$mv =move_uploaded_file($_FILES['center_logo']['tmp_name'],$logofilename);
					$query_imageup="UPDATE logo SET center_logo='".$logoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			
			if(false && isset($_FILES['right_logo']) && $_FILES['right_logo']['error']==0)
			{

				$array = explode('.', $_FILES['right_logo']['name']);
				$logoimage = $array[0];
				$logoimage1 = $array[1];
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage.".".$logoimage1;  

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT right_logo FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['right_logo']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = "uploads/right_logo/".$logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = "uploads/right_logo/". $logoimage;
					$mv =move_uploaded_file($_FILES['right_logo']['tmp_name'],$logofilename);
					$query_imageup="UPDATE logo SET right_logo='".$logoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			
			if(false && isset($_FILES['footer_logo']) && $_FILES['footer_logo']['error']==0)
			{

				$array = explode('.', $_FILES['footer_logo']['name']);
				$logoimage = $array[0];
				$logoimage1 = $array[1];
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage.".".$logoimage1;  

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT footer_logo FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['footer_logo']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = "uploads/footer_logo/".$logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = "uploads/footer_logo/". $logoimage;
					$mv =move_uploaded_file($_FILES['footer_logo']['tmp_name'],$logofilename);
					$query_imageup="UPDATE logo SET footer_logo='".$logoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			if(false && isset($_FILES['iso_logo']) && $_FILES['iso_logo']['error']==0)
			{

				$array = explode('.', $_FILES['iso_logo']['name']);
				$logoimage = $array[0];
				$logoimage1 = $array[1];
				$time =time();
				$logoimage = $time.$logoimage;
				$logoimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($logoimage)))); 
				$logoimage = $logoimage.".".$logoimage1;  

			    $logoimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT iso_logo FROM `logo` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$logoimagename =  trim($resultinfo['iso_logo']);
					}
					}
					}
						if($logoimagename!="")
						{
						$unlkheaderfile = "uploads/iso_logo/".$logoimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$logofilename = "uploads/iso_logo/". $logoimage;
					$mv =move_uploaded_file($_FILES['iso_logo']['tmp_name'],$logofilename);
					$query_imageup="UPDATE logo SET iso_logo='".$logoimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			
			
			echo "<script>document.location.href='add-logo.php?msg=".$sess_msg."';</script>";
			exit;
		
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM logo WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$logo_title = stripslashes($result['logo_title']);
			$logo_image   = $result['logo_image'];
			$fav_icon_image  = $result['fav_icon_image'];
			$left_logo  = $result['left_logo'];
			$center_logo  = $result['center_logo'];
			$right_logo  = $result['right_logo'];
			$footer_logo  = $result['footer_logo'];
			$iso_logo  = $result['iso_logo'];
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='add-logo.php';</script>";
			exit;
		}
    }
}

$logo_site_url = rtrim($site_root, '/') . '/';
$logo_preview_urls = array();
foreach (array_merge(array('logo_image' => 'logo'), $logo_asset_folders) as $logo_field => $logo_folder) {
	$logo_file = ${$logo_field} ?? '';
	$logo_path = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $logo_folder . DIRECTORY_SEPARATOR . $logo_file;
	$logo_preview_urls[$logo_field] = ($logo_file && file_exists($logo_path))
		? $logo_site_url . 'admin/uploads/' . $logo_folder . '/' . rawurlencode($logo_file)
		: $logo_site_url . 'assets/img/logo-new.png';
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
		<style>
			.logo-preview {
				display:block;
				width:220px;
				height:90px;
				padding:10px;
				object-fit:contain;
				border:1px solid #e5eaee;
				border-radius:6px;
				background:#f7f9fa;
				margin-bottom:10px;
			}
		</style>
    
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
           <?php if(isset($_REQUEST['msg'])) { ?> <h5 class="h5-headn hegt-96" style="color:green;"><?php echo $_REQUEST['msg']; ?></h5> <?php } else { ?>
           <h3>Add Logo</h3>
		   <?php } ?>
           </div>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form method="post" enctype="multipart/form-data">
              <div class="row">
               <div class="col-md-4">
                    <label class="input-text">Logo Title</label>
                  <div class="form-group">
                      <input type="text" name="logo_title" value="<?php echo $logo_title; ?>" class="from-control custom-type">
                   </div>
                  </div>
                    <div class="col-md-4">
                    <label class="input-text">Logo Image</label>
                    <div class="form-group">
					<?php 
					   if($logo_image!="")
						   {
					?>
					<?php
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['logo_image'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="<?php echo htmlspecialchars($logo_title, ENT_QUOTES, 'UTF-8'); ?>">
					   <?php 
						  }	
					   ?>
                      <input type="file" name="logo_image" class="from-control custom-type">
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">Favicon Icon Image</label>
                    <div class="form-group">
					  <?php 
					   if($fav_icon_image!="")
						   {
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['fav_icon_image'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="Favicon">
					<?php
						   }
					   ?>
                      <input type="file" name="fav_icon_image" class="from-control custom-type">
                   </div>
                  </div>
                 
                  </div>
                  <div class="row">
                  <div class="col-md-4">
                    <label class="input-text">Left Logo</label>
                    <div class="form-group">
					  <?php 
					   if($left_logo!="")
						   {
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['left_logo'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="Left logo">
					<?php
						   }
					   ?>
                      <input type="file" name="left_logo" class="from-control custom-type">
                   </div>
                  </div>
                       <div class="col-md-4">
                    <label class="input-text">Center Logo</label>
                    <div class="form-group">
					  <?php 
					   if($center_logo!="")
						   {
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['center_logo'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="Center logo">
					<?php
						   }
					   ?>
                      <input type="file" name="center_logo" class="from-control custom-type">
                   </div>
                  </div>
                   <div class="col-md-4">
                    <label class="input-text">Right Logo</label>
                    <div class="form-group">
					  <?php 
					   if($right_logo!="")
						   {
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['right_logo'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="Right logo">
					<?php
						   }
					   ?>
                      <input type="file" name="right_logo" class="from-control custom-type">
                   </div>
                  </div>
                        <div class="col-md-4">
                    <label class="input-text">Footer Logo</label>
                    <div class="form-group">
					  <?php 
					   if($footer_logo!="")
						   {
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['footer_logo'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="Footer logo">
					<?php
						   }
					   ?>
                      <input type="file" name="footer_logo" class="from-control custom-type">
                   </div>
                  </div>
                    <div class="col-md-4">
                    <label class="input-text">ISO Logo</label>
                    <div class="form-group">
					  <?php 
					   if($iso_logo!="")
						   {
					?>
					<img src="<?php echo htmlspecialchars($logo_preview_urls['iso_logo'], ENT_QUOTES, 'UTF-8'); ?>" class="logo-preview" alt="ISO logo">
					<?php
						   }
					   ?>
                      <input type="file" name="iso_logo" class="from-control custom-type">
                   </div>
                  </div>
                  <div class="col-md-12">
                      
                   <button type="submit" name="submit" value="add" class="btn btn-submit">Submit</button>     
                                            
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
    <strong>Copyright &copy; 2014-<?php echo date("Y"); ?> <a href="#">Dashboard</a>.</strong> All rights
    reserved.
  </footer>
</div>
	

<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>


</body>
</html>
