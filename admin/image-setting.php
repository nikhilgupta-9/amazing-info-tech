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

$actualimg_height = "";
$actualimg_width ="";
$zoomimg_height ="";
$zoomimg_width = ""; 
$normalimg_height  = "";
$normalimg_width ="";
$smallimg_height = "";
$smallimg_width ="";
$thumb_height  ="";
$thumb_width  ="";
$pdzoomimg_height  ="";
$pdzoomimg_width ="";
$pdhomepdimg_height ="";
$pdhomepdimg_width  ="";
$pdimg_height  ="";
$pdimg_width  ="";
$pdcustimg_height  ="";
$pdcustimg_width   ="";
$pdsmall_height   ="";
$pdsmall_width   ="";
$pdthum_height  ="";
$pdthum_width ="";
$pdslide_height ="";
$pdslide_width ="";
$logo_img_height  ="";
$logo_img_width  ="";
$hdsild_img_height  ="";
$hdsild_img_width ="";
$galimg_height ="";
$galimg_width ="";

$query = "SELECT * FROM cms_image ORDER BY id DESC";
if($sql_query = $conn->query($query))
{
if($sql_query->num_rows>0)
{
$result = $sql_query->fetch_array(MYSQLI_ASSOC);
$actualimg_height = $result['actualimg_height'];
$actualimg_width = $result['actualimg_width'];
$zoomimg_height = $result['zoomimg_height'];
$zoomimg_width = $result['zoomimg_width'];
$normalimg_height = $result['normalimg_height'];
$normalimg_width = $result['normalimg_width'];
$smallimg_height = $result['smallimg_height'];
$smallimg_width = $result['smallimg_width'];
$thumb_height = $result['thumb_height'];
$thumb_width = $result['thumb_width'];
$pdzoomimg_height = $result['pdzoomimg_height'];
$pdzoomimg_width = $result['pdzoomimg_width'];
$pdhomepdimg_height = $result['pdhomepdimg_height'];
$pdhomepdimg_width = $result['pdhomepdimg_width'];
$pdimg_height = $result['pdimg_height'];
$pdimg_width = $result['pdimg_width'];
$pdcustimg_height = $result['pdcustimg_height'];
$pdcustimg_width = $result['pdcustimg_width'];
$pdsmall_height = $result['pdsmall_height'];
$pdsmall_width = $result['pdsmall_width'];
$pdthum_height = $result['pdthum_height'];
$pdthum_width = $result['pdthum_width'];
$pdslide_height = $result['pdslide_height'];
$pdslide_width = $result['pdslide_width'];
$logo_img_height = $result['logo_img_height'];
$logo_img_width = $result['logo_img_width'];
$hdsild_img_height = $result['hdsild_img_height'];
$hdsild_img_width = $result['hdsild_img_width'];
$galimg_height = $result['galimg_height'];
$galimg_width = $result['galimg_width'];
$id = $result['id'];
}
}



if(isset($_REQUEST['submit']) && $_REQUEST['submit']=="update")

{


$actualimg_height = addslashes(trim($_POST['actualimg_height']));
$actualimg_width = addslashes(trim($_POST['actualimg_width']));
$zoomimg_height = addslashes(trim($_POST['zoomimg_height']));
$zoomimg_width = addslashes(trim($_POST['zoomimg_width']));
$normalimg_height = addslashes(trim($_POST['normalimg_height']));
$normalimg_width = addslashes(trim($_POST['normalimg_width']));
$smallimg_height = addslashes(trim($_POST['smallimg_height']));
$smallimg_width = addslashes(trim($_POST['smallimg_width']));
$thumb_height = addslashes(trim($_POST['thumb_height']));
$thumb_width = addslashes(trim($_POST['thumb_width']));
$pdzoomimg_height = addslashes(trim($_POST['pdzoomimg_height']));
$pdzoomimg_width = addslashes(trim($_POST['pdzoomimg_width']));
$pdhomepdimg_height = addslashes(trim($_POST['pdhomepdimg_height']));
$pdhomepdimg_width = addslashes(trim($_POST['pdhomepdimg_width']));
$pdimg_height = addslashes(trim($_POST['pdimg_height']));
$pdimg_width = addslashes(trim($_POST['pdimg_width']));
$pdcustimg_height = addslashes(trim($_POST['pdcustimg_height']));
$pdcustimg_width = addslashes(trim($_POST['pdcustimg_width']));
$pdsmall_height = addslashes(trim($_POST['pdsmall_height']));
$pdsmall_width = addslashes(trim($_POST['pdsmall_width']));
$pdthum_height = addslashes(trim($_POST['pdthum_height']));
$pdthum_width = addslashes(trim($_POST['pdthum_width']));
$pdslide_height = addslashes(trim($_POST['pdslide_height']));
$pdslide_width = addslashes(trim($_POST['pdslide_width']));
$logo_img_height = addslashes(trim($_POST['logo_img_height']));
$logo_img_width = addslashes(trim($_POST['logo_img_width']));
$hdsild_img_height = addslashes(trim($_POST['hdsild_img_height']));
$hdsild_img_width = addslashes(trim($_POST['hdsild_img_width']));
$galimg_height = addslashes(trim($_POST['galimg_height']));
$galimg_width = addslashes(trim($_POST['galimg_width']));


 $query_update="UPDATE cms_image SET actualimg_height='".$actualimg_height."',actualimg_width='".$actualimg_width."',zoomimg_height='".$zoomimg_height."',zoomimg_width='".$zoomimg_width."',normalimg_height='".$normalimg_height."',normalimg_width='".$normalimg_width."',smallimg_height='".$smallimg_height."',smallimg_width='".$smallimg_width."',thumb_height='".$thumb_height."',thumb_width='".$thumb_width."',pdzoomimg_height='".$pdzoomimg_height."',pdzoomimg_width='".$pdzoomimg_width."',pdhomepdimg_height='".$pdhomepdimg_height."',pdhomepdimg_width='".$pdhomepdimg_width."',pdimg_height='".$pdimg_height."',pdimg_width='".$pdimg_width."',pdcustimg_height='".$pdcustimg_height."',pdcustimg_width='".$pdcustimg_width."',pdsmall_height='".$pdsmall_height."',pdsmall_width='".$pdsmall_width."',pdthum_height='".$pdthum_height."',pdthum_width='".$pdthum_width."',pdslide_height='".$pdslide_height."',pdslide_width='".$pdslide_width."',logo_img_height='".$logo_img_height."',logo_img_width='".$logo_img_width."',hdsild_img_height='".$hdsild_img_height."',hdsild_img_width='".$hdsild_img_width."',galimg_height='".$galimg_height."',galimg_width='".$galimg_width."' WHERE id='$id'"; 



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
}


$query = "SELECT * FROM cms_image ORDER BY id DESC";
if($sql_query = $conn->query($query))
{
if($sql_query->num_rows>0)
{
$result = $sql_query->fetch_array(MYSQLI_ASSOC);
$actualimg_height = $result['actualimg_height'];
$actualimg_width = $result['actualimg_width'];
$zoomimg_height = $result['zoomimg_height'];
$zoomimg_width = $result['zoomimg_width'];
$normalimg_height = $result['normalimg_height'];
$normalimg_width = $result['normalimg_width'];
$smallimg_height = $result['smallimg_height'];
$smallimg_width = $result['smallimg_width'];
$thumb_height = $result['thumb_height'];
$thumb_width = $result['thumb_width'];
$pdzoomimg_height = $result['pdzoomimg_height'];
$pdzoomimg_width = $result['pdzoomimg_width'];
$pdhomepdimg_height = $result['pdhomepdimg_height'];
$pdhomepdimg_width = $result['pdhomepdimg_width'];
$pdimg_height = $result['pdimg_height'];
$pdimg_width = $result['pdimg_width'];
$pdcustimg_height = $result['pdcustimg_height'];
$pdcustimg_width = $result['pdcustimg_width'];
$pdsmall_height = $result['pdsmall_height'];
$pdsmall_width = $result['pdsmall_width'];
$pdthum_height = $result['pdthum_height'];
$pdthum_width = $result['pdthum_width'];
$pdslide_height = $result['pdslide_height'];
$pdslide_width = $result['pdslide_width'];
$logo_img_height = $result['logo_img_height'];
$logo_img_width = $result['logo_img_width'];
$hdsild_img_height = $result['hdsild_img_height'];
$hdsild_img_width = $result['hdsild_img_width'];
$galimg_height = $result['galimg_height'];
$galimg_width = $result['galimg_width'];
}
}



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Admin</title>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
   <?php include('header.php') ?>
  <?php include('left-menu.php') ?>
  <div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
       <div class="col-md-12">
          <div class="box">
            <div class="main-title">
           <h3>Image Setting</h3>
           </div>
          <div class="box-body">
               <div class="field-section">
                  
               <form action="" method="post">
                    <h3>CMS Image Setting</h3>
                   
                   <div class="row">
            <div class="col-md-12 col-sm-6 col-xs-12 marginpadding0  cl-r">
            	
               	<div class="col-md-2 ">
                    <label class="input-text">Actual Image</label>
                    </div>
                <div class="col-md-2 ">
                    <label class="input-text">Zoom Image</label>
                    </div>
                <div class="col-md-2">
                    <label class="input-text">Normal Image</label>
                    </div>
                  <div class="col-md-2 ">
                      <label class="input-text">Small Image</label>
                    </div>
                 <div class="col-md-2 ">
                     <label class="input-text">Thumb Image</label>
                    </div>
              
               
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12 marginpadding0  cl-r">
        	<div class="col-md-2 from-txt ">
          <input type="text" size="4" placeholder="Width" name="actualimg_height" value="<?php echo $actualimg_height; ?>">
          <input type="text" size="4" placeholder="Height" name="actualimg_width" value="<?php echo $actualimg_width; ?>">
           </div>
          <div class="col-md-2 from-txt ">
            <input type="text" size="4" placeholder="Width" name="zoomimg_height" value="<?php echo $zoomimg_height; ?>">
            <input type="text" size="4" placeholder="Height" name="zoomimg_width" value="<?php echo $zoomimg_width; ?>">
            </div>
          <div class="col-md-2 from-txt ">
          <input type="text" size="4" placeholder="Width" name="normalimg_height" value="<?php echo $normalimg_height; ?>">
           <input type="text" size="4" placeholder="Height" name="normalimg_width" value="<?php echo $normalimg_width; ?>">
          </div>
          <div class="col-md-2 from-txt ">
         <input type="text" size="4" placeholder="Width" name="smallimg_height" value="<?php echo $smallimg_height; ?>">
          <input type="text" size="4" placeholder="Height" name="smallimg_width" value="<?php echo $smallimg_width; ?>">
          </div>
         <div class="col-md-2 from-txt ">
           <input type="text" size="4" placeholder="Width" name="thumb_height" value="<?php echo $thumb_height; ?>">
          <input type="text" size="4" placeholder="Height" name="thumb_width" value="<?php echo $thumb_width; ?>">
          </div>
        
        
            </div>
                      </div>
                    <h3>Product Image Setting</h3>
                   
                   <div class="row">
              <div class="col-md-12 from-txt">
                  <label class="input-text">Zoom Image :</label>
            <input type="text" size="4" placeholder="Width" name="pdzoomimg_height" value="<?php echo $pdzoomimg_height; ?>">
          <input type="text" size="4" placeholder="Height" name="pdzoomimg_width" value="<?php echo $pdzoomimg_width; ?>">
          
         <span style="margin-left:10px;"></span>
                  <label class="input-text">Home &amp; Product Image :</label>
            <input type="text" size="4" placeholder="Width" name="pdhomepdimg_height" value="<?php echo $pdhomepdimg_height; ?>">
          <input type="text" size="4" placeholder="Height" name="pdhomepdimg_width" value="<?php echo $pdhomepdimg_width; ?>">
          
           <span style="margin-left:10px;"></span> 
                  <label class="input-text">Product Detail Image :</label>
             <input type="text" size="4" placeholder="Width" name="pdimg_height" value="<?php echo $pdimg_height; ?>">
         <input type="text" size="4" placeholder="Height" name="pdimg_width" value="<?php echo $pdimg_width; ?>">

        
          <span style="margin-left:10px;"></span>
                  <label class="input-text">Customized Image :</label>
           <input type="text" size="4" placeholder="Width" name="pdcustimg_height" value="<?php echo $pdcustimg_height; ?>">
          <input type="text" size="4" placeholder="Height" name="pdcustimg_width" value="<?php echo $pdcustimg_width; ?>">
          
           <span style="margin-left:10px;"></span>
                  <label class="input-text">Small Image :</label>
           <input type="text" size="4" placeholder="Width" name="pdsmall_height" value="<?php echo $pdsmall_height; ?>">
          <input type="text" size="4" placeholder="Height" name="pdsmall_width" value="<?php echo $pdsmall_width; ?>">
         
          <span style="margin-left:10px;"></span>
                  <label class="input-text">Thumb Image :</label>
          <input type="text" size="4" placeholder="Width" name="pdthum_height" value="<?php echo $pdthum_height; ?>">
          <input type="text" size="4" placeholder="Height" name="pdthum_width" value="<?php echo $pdthum_width; ?>">
          
            <span style="margin-left:10px;"></span>
                  <label class="input-text">Slider Image :</label>
          <input type="text" size="4" placeholder="Width" name="pdslide_height" value="<?php echo $pdslide_height; ?>">
          <input type="text" size="4" placeholder="Height" name="pdslide_width" value="<?php echo $pdslide_width; ?>">
          
          
        </div>
            </div>
        <div class="row"> 
         <div class="col-md-12 col-sm-6 col-xs-12 marginpadding0  cl-r">
        <div class="col-md-4">
            <h3>Logo Image Setting</h3>
            <label class="input-text">Image :</label>
         <input type="text" size="4"  placeholder="Width" name="logo_img_height" value="<?php echo $logo_img_height; ?>">
          <input type="text" size="4"  placeholder="Height" name="logo_img_width" value="<?php echo $logo_img_width; ?>">
         
        </div>
        <div class="col-md-4 from-txt">
            <h3>Header/Slider Image Setting</h3>
            <label class="input-text">Image :</label>
         <input type="text" size="4"  placeholder="Width" name="hdsild_img_height" value="<?php echo $hdsild_img_height; ?>">
          <input type="text" size="4"  placeholder="Height" name="hdsild_img_width" value="<?php echo $hdsild_img_width; ?>">
         
        </div>
        <div class="col-md-4 from-txt">
            <h3>Gallery Image Setting</h3>
            <label class="input-text">Image :</label>
          <input type="text" size="4"  placeholder="Width" name="galimg_height" value="<?php echo $galimg_height; ?>">
          <input type="text" size="4"  placeholder="Height" name="galimg_width" value="<?php echo $galimg_width; ?>">
        
        </div>
      </div>
      <div class="col-md-12 col-sm-6 col-xs-12 marginpadding0  cl-r">
        <div class="col-md-10 from-txt"> &nbsp;</div>
        <div class="col-md-2 from-txt ">
          <input type="submit" class="btn btn-primary button col-md-12" value="update" name="submit" id="submit">
        </div>
                   </div>
                   </div>
                   </form>
              </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>

 <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="#">Dashboard</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<script src="dist/js/adminlte.min.js"></script>
    

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
    $(document).ready(function() {
    $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkedAll").prop("checked", true);
            }     
        }
        else {
            $("#checkedAll").prop("checked", false);
        }
    });
});
    </script>
</body>

</html>
