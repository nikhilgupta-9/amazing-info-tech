<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

/* set variable */
$pagename = "Brand Logo";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$team_img = "";
$team_img_alt = "";
$team_name = "";
$team_desg = "";
$team_fb_link = "";
$team_twitter_link = "";
$team_insta_link = "";
$team_skype_link = "";
$is_active = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	
	$team_img_alt = addslashes(trim($_POST['team_img_alt']));
	$team_name = addslashes(trim($_POST['team_name']));
	$team_desg = addslashes(trim($_POST['team_desg']));
	$team_fb_link = addslashes(trim($_POST['team_fb_link']));
	$team_twitter_link = addslashes(trim($_POST['team_twitter_link']));
	$team_insta_link = addslashes(trim($_POST['team_insta_link']));
	$team_skype_link = addslashes(trim($_POST['team_skype_link']));
	
	if(!empty($_POST['is_active'])) { $is_active=1; } else{ $is_active=0; }
	
	/* check title in database */
	$checkDuplicate ="";
	if($id!="")
	{
		$checkDuplicate = "AND id!='$id'"; 
	}
	$query_duplicate="SELECT * FROM tbl_team WHERE team_name='".$team_name."' $checkDuplicate";
	if($sql_duplicate=$conn->query($query_duplicate))
	{
		
			if($id!="")
			{
				$query_update="UPDATE tbl_team SET team_img_alt='".$team_img_alt."',team_name='".$team_name."',team_desg='".$team_desg."',team_fb_link='".$team_fb_link."',team_twitter_link='".$team_twitter_link."',team_insta_link='".$team_insta_link."',team_skype_link='".$team_skype_link."',is_active='".$is_active."' WHERE id='".$id."'";
				if($sql_update=$conn->prepare($query_update))
				{
					$sql_update->execute();
					$sess_msg = $pagename." Update Successfully.";	
				}
			}
			else
			{
				$query_insert="INSERT INTO tbl_team SET team_img_alt='".$team_img_alt."',team_name='".$team_name."',team_desg='".$team_desg."',team_fb_link='".$team_fb_link."',team_twitter_link='".$team_twitter_link."',team_insta_link='".$team_insta_link."',team_skype_link='".$team_skype_link."',is_active='".$is_active."'";
			

				if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}
			}
			

			if(isset($_FILES['team_img']) && $_FILES['team_img']['error']==0)
			{

				$array = explode('.', $_FILES['team_img']['name']);
				$bannerimage = $array[0];
				$bannerimage1 = $array[1];
				$time =time();
				$bannerimage = $time.$bannerimage;
				$bannerimage = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($bannerimage)))); 
				$bannerimage = $bannerimage.".".$bannerimage1;  

			    $bannerimagename = "";
					if($id!="")
					{

					$queryinfo = "SELECT team_img FROM `tbl_team` WHERE id = '".$id."'";
					if($sql_select = $conn->query($queryinfo))
					{
					if($sql_select->num_rows>0)
					{
					$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

					$bannerimagename =  trim($resultinfo['team_img']);
					}
					}
					}
						if($bannerimagename!="")
						{
						$unlkheaderfile = "uploads/team/".$bannerimagename;
						if (file_exists($unlkheaderfile)) { unlink($unlkheaderfile); }
						}
					$bannerfilename = "uploads/team/". $bannerimage;
					$mv =move_uploaded_file($_FILES['team_img']['tmp_name'],$bannerfilename);
					$query_imageup="UPDATE tbl_team SET team_img='".$bannerimage."' WHERE id='".$id."'";
					if($sql_imageup=$conn->prepare($query_imageup))
					$sql_imageup->execute();
			} 

			
			echo "<script>document.location.href='view-team.php?msg=".$sess_msg."';</script>";
			exit;
	
	}
}

/* Listing  */
if($id!="")
{
  
    $query_select="SELECT * FROM tbl_team WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			
			$team_img = stripslashes($result['team_img']);
			$team_img_alt = stripslashes($result['team_img_alt']);
			$team_name = stripslashes($result['team_name']);
			$team_desg = stripslashes($result['team_desg']);
			$team_fb_link = stripslashes($result['team_fb_link']);
			$team_twitter_link = stripslashes($result['team_twitter_link']);
			$team_insta_link = stripslashes($result['team_insta_link']);
			$team_skype_link = stripslashes($result['team_skype_link']);
			$is_active = $result['is_active'];
			$pagetaskname = " Update ";

	
		}
		else
		{
			echo "<script>document.location.href='view-team.php';</script>";
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
           <h3>Add Brand Logo</h3>
           </div>
		   <?php } ?>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form method="post" enctype="multipart/form-data">
              <div class="row">
            

                  <div class="col-md-4">
                    <label class="input-text">Image</label>
                    <div class="form-group">
					<?php if($team_img!="") { ?>
					<img src="uploads/team/<?php echo $result['team_img']?>" height="100" width="120" title="<?php echo $title; ?> Image">
					<?php } ?>
                      <input type="file" name="team_img" value="<?php echo $result['team_img']?>" class="from-control custom-type">
                   </div>
                  </div>

                  <div class="col-md-4">
                    <label class="input-text">Image Alt Tag</label>
                  <div class="form-group">
                  	<input type="text" name="team_img_alt" class="from-control custom-type" value="<?php echo $team_img_alt?>">
                     
                      
                   </div>
                  </div>

               
              


                 
				  <div class="col-md-4">
                  <label class="input-text">Status</label>
                <br>
                 <label class="switch">
				 <input type="checkbox" class="form-control" name="is_active[]" id="is_active" value="1" <?php if($is_active==  1) { echo "checked"; } ?>/>
				<div id="is_active"></div>
                  
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
$("#is_active").toggleSwitch();
$("#myonoffswitch2").toggleSwitch();
});
</script>


</body>
</html>
