<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

/* set variable */
$pagename = "Opportunity";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$title = "";
$cid = "";
$image = "";
$content = "";
$status = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	
	$title = addslashes(trim($_POST['title']));
	$content = addslashes($_POST['content']);
	
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0; }
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM  tbl_opportunity WHERE title='".$title."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		if($sql_duplicate->num_rows>0)
		{
			$msg = "This Title is already exist, please try another.";
		}
		else
		{
			if($id!="")
			{
				$query_update="UPDATE  tbl_opportunity SET title='".$title."',status='".$status."',content='".$content."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$sess_msg = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO  tbl_opportunity SET title='".$title."',status='".$status."',content='".$content."'";
				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}
			}
			if(isset($_FILES['image']) && $_FILES['image']['error']==0)
			{

				$array = explode('.', $_FILES['image']['name']);
				$bannerimage = $array[0];
				$bannerimage1 = $array[1];
				$time =time();
				$bannerimage = $time.$bannerimage;
				$bannerimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($bannerimage)))); 
				$bannerimage = $bannerimage.".".$bannerimage1;  

			    $bannerimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT image FROM `banner` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$bannerimagename =  trim($resultinfo['image']);
					}
					}
					}
						if($bannerimagename!="")
						{
						$unlkheaderfile = "uploads/banner/".$bannerimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$bannerfilename = "uploads/banner/". $bannerimage;
					$mv =move_uploaded_file($_FILES['image']['tmp_name'],$bannerfilename);
					$query_imageup="UPDATE banner SET image='".$bannerimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			echo "<script>document.location.href='view-opportunity.php?msg=".$sess_msg."';</script>";
			exit;
		}
	}
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM  tbl_opportunity WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			
			$title = stripslashes($result['title']);
			$content = stripslashes($result['content']);
			$status = $result['status'];
			$image = $result['image'];
			$pagetaskname = " Update ";
		}
		else
		{
			echo "<script>document.location.href='view-opportunity.php';</script>";
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
           <h3>Add Opportunity</h3>
           </div>
		   <?php } ?>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form method="post" enctype="multipart/form-data">
              <div class="row">
               <div class="col-md-4">
                    <label class="input-text">Opportunity Title</label>
                  <div class="form-group">
                      <input type="text" name="title" value="<?php echo $title; ?>" class="from-control custom-type">
                   </div>
                  </div>
                   <div class="col-md-4">
                   <label class="input-text">Status</label>
                <br>
                 <label class="switch">
				 <input type="checkbox" class="form-control" name="status[]" id="status" value="1" <?php if($status==  1) { echo "checked"; } ?>/>
				<div id="status_status"></div>
                  
                   </label>
                  </div>
     <!--             <div class="col-md-4">-->
     <!--               <label class="input-text">Image</label>-->
     <!--               <div class="form-group">-->
					<!--<?php if($image!="") { ?>-->
					<!--<img src="uploads/banner/<?php echo $result['image']?>" height="100" width="120" title="<?php echo $title; ?> Image">-->
					<!--<?php } ?>-->
     <!--                 <input type="file" name="image" value="<?php echo $result['image']?>" class="from-control custom-type">-->
     <!--              </div>-->
     <!--             </div>
                   <div class="col-md-4">
                    <label class="input-text">Line 1</label>
                  <div class="form-group">
                      <input type="text" name="line1" value="<?php echo $line1;?>" class="from-control custom-type">
                   </div>
                  </div>-->
                  </div>
                  <div class="row">
                  
                 
                  <div class="col-md-12">
                    <label class="input-text"> Content</lable>
                      <div class="form-group">
                          <textarea name="content" class="from-control custom-type" rows="5" cols="100%"><?php echo $content;?></textarea>
                   
                  </div>                          
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


</body>
</html>
