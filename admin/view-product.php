<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}


if($_GET['proid']!="0")
{
	
	if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
	$query_select = "SELECT * FROM cat_prod WHERE id ='".$id."'";
	if($sql_select = $conn->query($query_select))
	{
		$result = $sql_select->fetch_array(MYSQLI_ASSOC);
		@unlink("uploads/video/".$result['video']);
		@unlink("uploads/fvicon/".$result['fvicon']);
		@unlink("uploads/up_image/".$result['up_image']);
		@unlink("uploads/up_pdf/".$result['up_pdf']);
	}
	$query_delete="DELETE FROM cat_prod WHERE id='".$id."'";
	if($sql_delete=$conn->query($query_delete))
	{
		$sess_msg="Deleted Successfully.";
							
	}
}

if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{
			$query_select= "SELECT * from cat_prod WHERE id ='".$value."'";
			if($sql_select=$conn->query($query_select))
			{
				while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
				{
					extract($result);
					@unlink("uploads/video/".$result['video']);
					@unlink("uploads/fvicon/".$result['fvicon']);
					@unlink("uploads/up_image/".$result['up_image']);
					@unlink("uploads/up_pdf/".$result['up_pdf']);
				}
			}		
			if($sql_deleteall=$conn->query("DELETE FROM cat_prod WHERE id = '".$value."'"))
			{
				$sess_msg="Deleted Successfully.";					
			}
	    }
		
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['chk_btn']) && !empty($_POST['chk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET status = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Activated Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['unchk_btn']) && !empty($_POST['unchk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET status = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Deactivated Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}


if(isset($_POST['setashome']) && !empty($_POST['setashome']))
{
	
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		 $query_deact="UPDATE cat_prod SET setashome = '1' WHERE id IN (".$str_rest_refs.")"; 
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Set at Home Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}


if(isset($_POST['rsetashome']) && !empty($_POST['rsetashome']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET setashome = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove Home Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['sale_pd']) && !empty($_POST['sale_pd']))
{
	
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		 $query_deact="UPDATE cat_prod SET sale_pd = '1' WHERE id IN (".$str_rest_refs.")"; 
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Hot Sale Activated Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['rsale_pd']) && !empty($_POST['rsale_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET sale_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Unactivated Hot Sale Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['hot_pd']) && !empty($_POST['hot_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET hot_pd = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Hot Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rhot_pd']) && !empty($_POST['rhot_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET hot_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove Hot Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['new_av_pd']) && !empty($_POST['new_av_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET new_av_pd = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Hot Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rnew_av_pd']) && !empty($_POST['rnew_av_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET new_av_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove Hot Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['fd_pd']) && !empty($_POST['fd_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET fd_pd = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="featured Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rfd_pd']) && !empty($_POST['rfd_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET fd_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove featured Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['hotoffer']) && !empty($_POST['hotoffer']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET hotoffer = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="featured Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rhotoffer']) && !empty($_POST['rhotoffer']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET hotoffer = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove featured Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['updatedrteorder']) && !empty($_POST['updatedrteorder']))
{ 
   
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		
		
		foreach($_POST['check_status'] as $value)
		{
			
			foreach($_POST['updatedrteorder'] as $key => $value1)
			{

			
		if($key==$value) {
			  $query_act="UPDATE cat_prod SET updateorder = '".$value1."' WHERE id = '".$value."'";
			
			
			if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			
			$sess_msg="Updated Successfully.";			
		}
			 }
			 
		   }
		   
		  
			
	    }
		
		
	} 
	else
	{
		$sess_msg="Please select check box.";
		
	}
	
 }

	
}
if($_GET['proid']=='0')
{

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
	$query_select = "SELECT * FROM cat_prod WHERE id ='".$id."'";
	if($sql_select = $conn->query($query_select))
	{
		$result = $sql_select->fetch_array(MYSQLI_ASSOC);
		@unlink("uploads/video/".$result['video']);
		@unlink("uploads/fvicon/".$result['fvicon']);
		@unlink("uploads/up_image/".$result['up_image']);
		@unlink("uploads/up_pdf/".$result['up_pdf']);
	}
	$query_delete="DELETE FROM cat_prod WHERE id='".$id."'";
	if($sql_delete=$conn->query($query_delete))
	{
		$sess_msg="Deleted Successfully.";
						
	}
}

if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{
			$query_select= "SELECT * from cat_prod WHERE id ='".$value."'";
			if($sql_select=$conn->query($query_select))
			{
				while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
				{
					extract($result);
					@unlink("uploads/video/".$result['video']);
					@unlink("uploads/fvicon/".$result['fvicon']);
					@unlink("uploads/up_image/".$result['up_image']);
					@unlink("uploads/up_pdf/".$result['up_pdf']);
				}
			}		
			if($sql_deleteall=$conn->query("DELETE FROM cat_prod WHERE id = '".$value."'"))
			{
				$sess_msg="Deleted Successfully.";					
			}
	    }
		
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['chk_btn']) && !empty($_POST['chk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET status = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Activated Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['unchk_btn']) && !empty($_POST['unchk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET status = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Deactivated Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}


if(isset($_POST['setashome']) && !empty($_POST['setashome']))
{
	
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		 $query_deact="UPDATE cat_prod SET setashome = '1' WHERE id IN (".$str_rest_refs.")"; 
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Set at Home Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}


if(isset($_POST['rsetashome']) && !empty($_POST['rsetashome']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET setashome = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove Home Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['sale_pd']) && !empty($_POST['sale_pd']))
{
	
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		 $query_deact="UPDATE cat_prod SET sale_pd = '1' WHERE id IN (".$str_rest_refs.")"; 
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Hot Sale Activated Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['rsale_pd']) && !empty($_POST['rsale_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET sale_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Unactivated Hot Sale Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['hot_pd']) && !empty($_POST['hot_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET hot_pd = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Hot Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rhot_pd']) && !empty($_POST['rhot_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET hot_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove Hot Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['new_av_pd']) && !empty($_POST['new_av_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET new_av_pd = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Hot Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rnew_av_pd']) && !empty($_POST['rnew_av_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET new_av_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove Hot Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['fd_pd']) && !empty($_POST['fd_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET fd_pd = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="featured Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rfd_pd']) && !empty($_POST['rfd_pd']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET fd_pd = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove featured Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['hotoffer']) && !empty($_POST['hotoffer']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE cat_prod SET hotoffer = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="featured Product Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}
if(isset($_POST['rhotoffer']) && !empty($_POST['rhotoffer']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE cat_prod SET hotoffer = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Remove featured Products Successfully.";	
			
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		
	}
}

if(isset($_POST['updatedrteorder']) && !empty($_POST['updatedrteorder']))
{ 
   
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		
		
		foreach($_POST['check_status'] as $value)
		{
			
			foreach($_POST['updatedrteorder'] as $key => $value1)
			{

			
		if($key==$value) {
			  $query_act="UPDATE cat_prod SET updateorder = '".$value1."' WHERE id = '".$value."'";
			
			
			if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			
			$sess_msg="Updated Successfully.";			
		}
			 }
			 
		   }
		   
		  
			
	    }
		
		
	} 
	else
	{
		$sess_msg="Please select check box.";
		
	}
	
}

}
$sess_msg="";
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
		    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.css" /> 
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
          
		    <?php if($sess_msg!="") { ?> <h3 class="h5-headn hegt-96" style="color:red;"><?php echo $sess_msg; ?></h3> <?php } else { ?>			
           <h3>All Product</h3>
		   <?php } ?>
		   
		   
		   <ul  class="right-links">
		    <li><a href="view-product.php?proid=<?php echo $_GET['proid']; ?>">Main <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a></li>
		   <!--<li><a href="#">Proud <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a></li>
		    <li><a href="#">Main <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a></li>-->
		   </ul>
           </div>
		   <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
		   <?php 
			  if(isset($_GET['backid']) &&($_GET['proid']!="0"))
				{
					
			?>
           <a href="add-product.php?backid=<?php echo $_GET['backid']; ?>&proid=<?php echo $_GET['proid']; ?>" class="btn btn-addnew">Create New</a>
		   <?php
}
else if($_GET['proid']!="0")
{
	?>
	<a href="add-product.php?backid=0&proid=<?php echo $_GET['proid']; ?>" class="btn btn-addnew">Create New</a>
<?php 	
		                
				}
			?>
            <div class="box-body" style="overflow-x:auto;">
			<table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
              <tr>
            
                  <td colspan="7" style="text-align:left;">
                 <input type="submit" name="sale_pd" value="Set Sale Product" onClick="return confirm('Are you sure? You want to add at Hot Sale');" class="btn btn-primary">
                  <input type="submit" name="rsale_pd" value="Remove from Sale Product" onClick="return confirm('Are you sure? You want to Remove from Hot Sale');" class="btn btn btn-danger"> 				  
                   
                  <input type="submit" name="hot_pd" value="Hot Product" onClick="return confirm('Are you sure? You want to Hot Product');" class="btn btn-primary">
                  <input type="submit" name="rhot_pd" value="Remove Hot Product" onClick="return confirm('Are you sure? You want to Remove Hot Product');" class="btn btn btn-danger">
                  
                  <input type="submit" name="new_av_pd" value="New Arrival" onClick="return confirm('Are you sure? You want to New Arrival');" class="btn btn-primary">
                  <input type="submit" name="rnew_av_pd" value="Remove New Arrival" onClick="return confirm('Are you sure? You want to Remove New Arrival');" class="btn btn btn-danger"> 
               
                  <input type="submit" name="fd_pd" value="Featured" onClick="return confirm('Are you sure? You want to Featured');" class="btn btn-primary">
                  <input type="submit" name="rfd_pd" value="Remove Featured" onClick="return confirm('Are you sure? You want to Remove Featured');" class="btn btn btn-danger"> 
                  <input type="submit" name="hotoffer" value="Offer" onClick="return confirm('Are you sure? You want to Offer');" class="btn btn-primary">
                  <input type="submit" name="rhotoffer" value="Remove Offer" onClick="return confirm('Are you sure? You want to Remove Offer');" class="btn btn btn-danger"> 
                  <input type="submit" name="setashome" value="Set as Home" onClick="return confirm('Are you sure? You want to At Home');" class="btn btn-primary">
                  <input type="submit" name="rsetashome" value="Remove from  Home" onClick="return confirm('Are you sure? You want to Remove from Home');" class="btn btn btn-danger"> 
                   <input type="submit" name="delete_all" value="Delete / Block" class="btn btn-danger" style="margin-top:2px;" onClick="return confirm('Are you sure? You want to Delete');">
                  </td>
                  <td colspan="5" style="text-align:left;">
                  <!--<input type="submit" name="updatedrteorder" value="Update Order" onClick="return confirm('Are you sure you want to update order?');" class="btn btn-warning">-->
                   <input type="submit" name="chk_btn" value="Active" onClick="return confirm('Are you sure you want to activate ?');" class="btn btn-success">
                  <input type="submit" name="unchk_btn" value="Deactivate" onClick="return confirm('Are you sure you want to deactivate ?');" class="btn btn-danger">
                  </td>
                </tr>
                <tr>
                <th>Sr. N.</th>    
                  <th>Products Name</th>
                  <th></th>
                  <th>MRP/Price/Discount(%)/Selling Price</th>
                  <th>Stock Status</th>
                  <th>Sell/Hot Product/Featured/N.Arrival/Offer/is Home?</th>
                  <th>Status</th>
                 <th>
                       <input type="checkbox" name="checkedAll" id="checkedAll" />
                    </th>
                     <th>Action</th>
                </tr>
                </thead>
                <tbody>
			<?php 
			  
				if($_GET['proid']=="0")
				{
			
			?>
			
			    
                <?php 
                $query="SELECT * FROM cms_menu WHERE page_type='category' AND page_category='yes' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=0&proid=<?php echo $row['id']; ?>"><?php echo $row['page_name']; ?></a></td>
                  <td><a href="add-product.php?backid=0&proid=<?php echo $row['id']; ?>">Add product Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> In Stock</td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                    <!--  <ul class="edit-button">
                          <li><a href="#"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#"><i class="fa fa-remove"></i></a></li>
                      </ul>-->
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			  
            <!-- /.box-body -->
				<?php }
				
		    if(($_GET['proid']!='0')) { 
			
			$dataq="SELECT * FROM `cat_prod` WHERE `category_id`='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					$sql_select->num_rows;
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
					
				  	
					
		if(($_GET['backid']==0) && ($resultinfo['category_id']==$_GET['proid'])) 
{	
			
			?>
              
                <?php 
                 $query="SELECT * FROM cat_prod WHERE category_id='".$_GET['proid']."' AND sub_category_id='0' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['category_id']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['category_id']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                   <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			  
            <!-- /.box-body -->
				<?php 
			
				
			}
			   }	
					
				}		
     $dataq="SELECT * FROM cat_prod WHERE sub_category_id='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				   
 if (($resultinfo['category_id']==$_GET['backid'])&& ($resultinfo['sub_category_id']==$_GET['proid'])) 
{
	
	
?>

                <?php 
                $query="SELECT * FROM cat_prod WHERE sub_category_id='".$_GET['proid']."' AND sub_category_id1='0'  AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                      <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			   
            <!-- /.box-body -->

<?php 
				
			}
			   }	
					
				}	
$dataq="SELECT * FROM cat_prod WHERE sub_category_id1='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				   

 if (($resultinfo['sub_category_id']==$_GET['backid'])&& ($resultinfo['sub_category_id1']==$_GET['proid'])) 
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id1='".$_GET['proid']."' AND sub_category_id2='0' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id1']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id1']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                     <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			   
 
<?php 
	      }	
					
				}			
}
$dataq="SELECT * FROM cat_prod WHERE sub_category_id2='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				   

 if (($resultinfo['sub_category_id1']==$_GET['backid'])&& ($resultinfo['sub_category_id2']==$_GET['proid'])) 
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id2='".$_GET['proid']."' AND sub_category_id3='0' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id2']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id2']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                    <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			  
  
<?php 
			 }	
					
				}
}
$dataq="SELECT * FROM cat_prod WHERE sub_category_id3='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				

 if (($resultinfo['sub_category_id2']==$_GET['backid'])&& ($resultinfo['sub_category_id3']==$_GET['proid'])) 
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id3='".$_GET['proid']."' AND sub_category_id4='0' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id3']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id3']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                   <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			   
 
<?php 
		    }	
					
				}		
}
$dataq="SELECT * FROM cat_prod WHERE sub_category_id4='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				    

 if (($resultinfo['sub_category_id3']==$_GET['backid'])&& ($resultinfo['sub_category_id4']==$_GET['proid'])) 
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id4='".$_GET['proid']."' AND sub_category_id5='0' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id4']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id4']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                    <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			  
 
<?php 
		}	
					
				}		
}
$dataq="SELECT * FROM cat_prod WHERE sub_category_id5='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				   

 if (($resultinfo['sub_category_id4']==$_GET['backid'])&& ($resultinfo['sub_category_id5']==$_GET['proid']))
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id5='".$_GET['proid']."' AND sub_category_id6='0' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id5']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id5']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> In Stock</td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                    <ul class="edit-button">
                           <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			   
  

<?php 
			 }	
					
				}	
}
$dataq="SELECT * FROM cat_prod WHERE sub_category_id6='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				   

 if (($resultinfo['sub_category_id5']==$_GET['backid'])&& ($resultinfo['sub_category_id6']==$_GET['proid']))
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id6='".$_GET['proid']."' AND sub_category_id7='' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id6']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id6']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                    <ul class="edit-button">
                          <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			   
 
<?php 
		 }	
					
				}		
}

$dataq="SELECT * FROM cat_prod WHERE sub_category_id7='".$_GET['proid']."'";
	             if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
					
						$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				  
 if (($resultinfo['sub_category_id6']==$_GET['backid'])&& ($resultinfo['sub_category_id7']==$_GET['proid']))
{
?>

                <?php 
               $query="SELECT * FROM cat_prod WHERE sub_category_id7='".$_GET['proid']."' AND sub_category_id8='' AND status='1'"; 
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
				?>    
                <tr>
                <td><?php echo $i; ?></td>    
                    <td><a href="view-product.php?backid=<?php echo $row['sub_category_id7']; ?>&proid=<?php echo $row['id']; ?>"><?php echo $row['ct_pd_name']; ?></a></td>
                  <td><a href="add-product.php?backid=<?php echo $row['sub_category_id7']; ?>&proid=<?php echo $row['id']; ?>">Add <?php echo $row['ct_pd_name']; ?> Category</a></td>
                    <td>0.00/0.00/0.00/0.00</td>
                  <td> <?php if($row['stock']=="in_stock"){echo "in stock"; }else {echo "out of stock";} ?></td>
                  <td> <?php if($row['sale_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hot_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['fd_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['new_av_pd']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['hotoffer']=='1') { echo "Yes"; }else { echo "No";} ?>/<?php if($row['setashome']=='1') { echo "Yes"; }else { echo "No";} ?></td>
                   <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?></td>
                    
                 <td>
                    <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle"  />
                    </td>
                  <td>
                      
                    <ul class="edit-button">
                          <li><a href="add-products.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
               
			   <?php
                    $i++;
                  }                  
                }

                 ?>
			   
<?php 
     }	
					
				}
}
	} ?>
		   </tbody>
              </table>
			  
			  
			  
			
            </div>	
          </div>
          <!-- /.box -->
		  </form>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
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

    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert-dev.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert-dev.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js"></script> 
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
	
	<script>
  function remove(ids){ 
  
  swal({   title: "Are you sure?", 
    text: "Want remove this menu", 
    type: "warning",  
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",  
    cancelButtonText: "No, cancel it!",
    confirmButtonText: "Yes, remove it!", 
    showLoaderOnConfirm:true, 
    closeOnConfirm: false,   
    closeOnCancel: true }, 
    function(isConfirm){   
      if (isConfirm) {    
       $.ajax({
        url: "sandeepphp/actions.php",
        data: {'id': ids ,'remove_product':'action'} ,
        type: "POST",
        success: function (data) {
          if(data=='OK'){
            swal("Remove!", "Menu has been removed", "success"); 
            location.reload();
          }
          else{
            sweetAlert("Oops", data, "error");
          }
          },
          error: function () {
            sweetAlert("Oops...", data, "error");
          }
        });
      }  
    });       
  }        
</script>
	<script>
$("#checkAllbox").change(function () {
    $(".checkbox").prop('checked', $(this).prop("checked"));
});
</script>
</body>

</html>
