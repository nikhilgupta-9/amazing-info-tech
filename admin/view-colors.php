<?php
include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}


if(isset($_GET['type']) && $_GET['type']!=''){
    $type=$_GET['type'];
    if($type=='status'){
        $operation=$_GET['operation'];
        $id=$_GET['id'];
        if($operation=='active'){
            $status='0';
        }else{
            $status='1';
        }
        $update_status_sql="update colors set status='$status' where id='$id'";
        mysqli_query($conn,$update_status_sql);
         ?>
        <script>
            window.location.href='view-colors.php';
        </script>
        <?php
    }
    
    if($type=='delete'){
        
        $id=$_GET['id'];
        
      
        $delete_sql="delete from colors where id='$id'";

        mysqli_query($conn,$delete_sql);
        echo '<script>alert("Data Deleted Succesfully")</script>';
        ?>
           <script>
            window.location.href = 'view-colors.php';
           </script>
            <?php
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
        <div class="col-xs-12">

          <div class="box">
            <div class="main-title">
           <h3>Add Numbers</h3>
          
          
           </div>
           <a href="add-colors.php" class="btn btn-addnew">Add Numbers</a>
               
        
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.NO</th> 
                  <th>Title</th>
                  <th>Content</th>
                  <th>Code</th>
                  
                  <th>Status</th>
                  <th>Action</th>
                 
                </tr>
                </thead>
                <tbody>
             
               <?php
               $sql=mysqli_query($conn,"select * from colors");
                $i=1;
               while($row=mysqli_fetch_array($sql)){

              
               ?>

                <tr>
                  <td><?php echo $i  ?></td>    
                  <td><?php echo $row['name'] ?></td>
                   <td><?php echo $row['content'] ?></p></td>
                <td><?php echo $row['code'] ?></td>
                   
                  
                  <td>  
                   <?php
                          if($row['status']=='1')
                                            {
                                                echo "<span class='badge badge-edit'><a href='?type=status&operation=active&id=".$row['id']."'>active</a></span>&nbsp;"; 
                                            }
                                            else
                                            {
                                                 echo "<span class='badge badge-edit'><a href='?type=status&operation=deactive&id=".$row['id']."'>deactive</a></span>&nbsp;";  
                                            }
                            ?>
                  </td>
                  <td>
                      <ul class="edit-button">
                          <li><a href="add-colors.php?id=<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></a></li>
                          <li>
                            <?php 
                             echo "<span class=''><a href='?type=delete&id=".$row['id']."''><i class='fa fa-remove'></i></a></span>";
                            ?>                
                          
                          

                      </ul>
                  </td>
                </tr>
              
<?php
$i++;
}
?>

                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <style>
    .badge{
      padding: 10px;
      background: #234564;

    }
    .badge a{
      color: white!important;

    }
  </style>
  <!-- /.content-wrapper -->
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

</body>

</html>
