<?php

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}


/* set variable */
$pagename = "Product";
$pagetaskname = " Add ";

/* set var blank */
  $id = "";
  $msg ="";
  $name ="";      
  $code  =""; 
  $content="";    
  
  $status=""; 

  if(isset($_GET['id']) && $_GET['id']!=''){
    $id=mysqli_real_escape_string($conn,$_GET['id']);
    $res=mysqli_query($conn,"select * from colors where id='$id'");
    $check=mysqli_num_rows($res);
    if($check>0){
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        $code=$row['code'];
        $content=$row['content'];
      
        $status=$row['status']; 
    } else{
        header('location:add-colors.php');
        die();
    }
}


 if(isset($_POST['submit'])){
  $name=mysqli_real_escape_string($conn,$_POST['name']);
  $content=$_POST['content'];
  $code=mysqli_real_escape_string($conn,$_POST['code']);          
    
  
      
 //check duplicacy of data
  $res=mysqli_query($conn,"select * from colors where ct_pd_name='$ct_pd_name'");
    $check=mysqli_num_rows($res);
    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData=mysqli_fetch_assoc($res);
            if($id==$getData['id']){
            
            }else{
                $msg="Sub Categories already exist";
                echo "<script>alert('Categories already exist')</script>";
            }
        }else{
            $msg="Categories already exist";
            echo "<script>alert('Categories already exist')</script>";
        }
    }

if($msg==''){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $id=$_GET['id'];


          if((empty($_FILES['uploadfile']['name']))){
            mysqli_query($conn,"UPDATE `colors` SET `name`='$name',`code`='$code',`content`='$content' where id='$id'");
            ?>
   <script>
     window.location.href="view-colors.php";
   </script>
   <?php  
          }else{
             $filename = $_FILES["uploadfile"]["name"];
             $tempname = $_FILES["uploadfile"]["tmp_name"];    
             $folder = "../admin/uploads/category/".$filename;
            move_uploaded_file($tempname, $folder);

            mysqli_query($conn,"UPDATE `colors` SET `name`='$name',`code`='$code',`content`='$content' where id='$id'");
            ?>
   <script>
     window.location.href="view-colors.php";
   </script>
   <?php  
          }
          

   

  }else{
  
   mysqli_query($conn, "INSERT INTO `colors`( `name`, `code`, `status`,`content`) VALUES ('$name','$code','1','$content')"); 
   echo "<script>alert('inserted successfully')</script>";    
   ?>
   <script>
     window.location.href="view-colors.php";
   </script>
   <?php       

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
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalabel=no" name="viewport"> 
  <title>Dashboard</title>
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="dist/js/editor.js"></script>
	
    
    <script>
$(function(){
$("#status").toggleSwitch();
$("#myonoffswitch2").toggleSwitch();
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <section class="content">
      <div class="row">
       <div class="col-md-12">
          <div class="main-title">
           <h3>Add Numbers</h3>
          
           </div>
          </div>
         </div>
         <div class="row"> 
          <div class="col-md-10 col-md-offset-1">
          <div class="field-section">
              <form method="post" enctype="multipart/form-data">
               

               <div class="row">
                
                   <div class="col-md-6">
                     <label class="input-text">Title</label>
                     <div class="form-group">
                     <input type="text" name="name" value="<?php echo $name; ?>" required class="from-control custom-type">
                     </div>
                   </div>

                   <div class="col-md-6">
                     <label class="input-text">Code</label>
                     <div class="form-group">
                     <input type="text" name="code" value="<?php echo $code; ?>" required class="from-control custom-type">
                     </div>
                   </div>

                    <div class="col-md-6">
                     <label class="input-text">Content</label>
                     <div class="form-group">
                     <input type="text" name="content" value="<?php echo $content; ?>" required class="from-control custom-type">
                     </div>
                   </div>
                
                 
               </div>

                
                <input type="submit" name="submit" values="submit">
                
                
              </form>
              </div>
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

<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

</body>
</html>
