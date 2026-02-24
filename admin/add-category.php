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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <section class="content">
      <div class="row">
       <div class="col-md-12">
          <div class="main-title">
           <h3>Add Category</h3>
           </div>
          </div>
          <div class="col-md-10 col-md-offset-1">
          <div class="field-section">
              <form>
              <div class="row">
            
                   <div class="col-md-6">
                    <label class="input-text"> Title</label>
                  <div class="form-group">
                      <input type="text" class="from-control custom-type">
                   </div>
                  </div>
                  <div class="col-md-6">
                    <label class="input-text"> Meta Title</label>
                  <div class="form-group">
                      <input type="text" class="from-control custom-type">
                   </div>
                  </div>
                   <div class="col-md-6">
                    <label class="input-text">Image</label>
                  <div class="form-group">
                      <input type="file" class="from-control custom-type">
                   </div>
                  </div>
                  <div class="col-md-6">
                   <label class="input-text">Status</label>
                      <br>
                 <label class="switch">
  <input type="checkbox" checked>
  <span class="slider round"></span>
</label>
                  </div>
                   <div class="col-md-12">
                    <label class="input-text"> Meta Descriptions</label> 
                       <textarea id="txtEditor"></textarea>
                     <button type="submit" class="btn btn-submit">Add</button> 
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


</body>
</html>
