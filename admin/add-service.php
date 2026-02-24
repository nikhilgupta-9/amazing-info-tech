<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

/* set variable */
$pagename = "service";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$sess_msg ="";
	$ct_pd_name	="";			

	$ct_pd_url	="";			

	$ct_pd_sl	="";			

	$ct_pd_title ="";				

	$ct_pd_ky	="";			

	$ct_pd_mt_ds="";				

	$ic_image	="";				

	$hd_image	="";				

	$hd_sl_image ="";					

	$zoom_image_width	="";				

	$zoom_image_height	="";				

	$home_pd_width	="";				

	$home_pd_height	="";				

	$pd_dl_width		="";			

	$pd_dl_height		="";			

	$cust_img_width		="";			

	$cust_img_height		="";			

	$sm_image_width		="";			

	$sm_image_height	="";				

	$tmb_width	="";				

	$tmb_height	="";				

	$cat_pd_image="";					

	$cat_pd_hv_image	="";				

	$cat_pd_pdf_image="";					

	$cat_pd_video="";					

	$cat_pd_mrp	="";				

	$cat_pd_price	="";				

	$cat_pd_dist		="";			

	$cat_pd_dist_amt	="";				

	$cat_pd_sale_price="";					

	$cat_pd_usd_mrp	="";				

	$cat_pd_usd_price="";					

	$cat_pd_usd_dist	="";				

	$cat_pd_dist_usd_amt	="";				

	$cat_pd_sale_usd_price	="";				

	$quantity		="";			

	$stock			="";		

	$small_description	="";				

	$long_description	="";				

	$free_return			="";		

	$warranty		="";			

	$shipping		="";			

	$dilivery		="";			

	$support_number	="";				

	$support_email	="";				

	$status="";	

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	
	
	$ct_pd_name = addslashes(ucwords(trim($_POST['ct_pd_name'])));
	$ct_pd_url = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($ct_pd_name))));
	$ct_pd_sl = addslashes(ucwords(trim($_POST['ct_pd_sl'])));
	$ct_pd_title = addslashes($_POST['ct_pd_title']);
	$ct_pd_ky = addslashes($_POST['ct_pd_ky']);
	$ct_pd_mt_ds = addslashes($_POST['ct_pd_mt_ds']);
	$zoom_image_width = $_POST['zoom_image_width'];
	$zoom_image_height = $_POST['zoom_image_height'];
	$home_pd_width = $_POST['home_pd_width'];
	$home_pd_height = $_POST['home_pd_height'];
	$pd_dl_width = $_POST['pd_dl_width'];
	$pd_dl_height = $_POST['pd_dl_height'];
	$cust_img_width = $_POST['cust_img_width'];
	$cust_img_height = $_POST['cust_img_height'];
	$sm_image_width = $_POST['sm_image_width'];
	$sm_image_height = $_POST['sm_image_height'];
	$tmb_width = $_POST['tmb_width'];
	$tmb_height = $_POST['tmb_height'];
	$cat_pd_mrp = $_POST['cat_pd_mrp'];
	$cat_pd_price = $_POST['cat_pd_price'];
	$cat_pd_dist = $_POST['cat_pd_dist'];
	$cat_pd_dist_amt = $_POST['cat_pd_dist_amt'];
	$cat_pd_sale_price = $_POST['cat_pd_sale_price'];
	$cat_pd_usd_mrp = $_POST['cat_pd_usd_mrp'];
	$cat_pd_usd_price = $_POST['cat_pd_usd_price'];
	$cat_pd_usd_dist = $_POST['cat_pd_usd_dist'];
	$cat_pd_dist_usd_amt = $_POST['cat_pd_dist_usd_amt'];
	$cat_pd_sale_usd_price = $_POST['cat_pd_sale_usd_price'];
	$quantity = $_POST['quantity'];
	$stock = $_POST['stock'];
	$small_description = $_POST['small_description'];
	$long_description = $_POST['long_description'];
	$free_return = $_POST['free_return'];
	$warranty = $_POST['warranty'];
	$shipping = $_POST['shipping'];
	$dilivery = $_POST['dilivery'];
	$support_number = $_POST['support_number'];
	$support_email = $_POST['support_email'];
	
	if(!empty($_POST['status'])) { $status=1; } else{ $status=0; }
	
	
	if(isset($_FILES['hd_sl_image']) && ($_FILES['hd_sl_image']['size']['0']))
			{
				
				
	 $errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/hd_sl_image";
				
				$counter = 0;
				if($_FILES["hd_sl_image"]["tmp_name"]!=""){
					echo "dsfkdslfsd";exit;
				foreach($_FILES["hd_sl_image"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["hd_sl_image"]["tmp_name"][$key];
                    $time =time();
					$hd_sl_image =  $time.$_FILES["hd_sl_image"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($hd_sl_image, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $hd_sl_image." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$hd_sl_image) == true){
						$UploadOk = false;
						array_push($errors, $hd_sl_image." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$hd_sl_image);
						array_push($uploadedFiles, $hd_sl_image);
					}
				}
				
				}
				

  if(count($uploadedFiles)>0){

 $hd_sl_image = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  }
			}
			
			
	    if(isset($_FILES['cat_pd_image']) && ($_FILES['cat_pd_image']['size']['0']))
			{
		 $errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/cat_pd_image";
				
				$counter = 0;
				if($_FILES["cat_pd_image"]["tmp_name"]!=""){
				foreach($_FILES["cat_pd_image"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["cat_pd_image"]["tmp_name"][$key];
                    $time =time();
					$cat_pd_image =  $time.$_FILES["cat_pd_image"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($cat_pd_image, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $cat_pd_image." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$cat_pd_image) == true){
						$UploadOk = false;
						array_push($errors, $cat_pd_image." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$cat_pd_image);
						array_push($uploadedFiles, $cat_pd_image);
					}
				}
				}
				

  if(count($uploadedFiles)>0){

 $cat_pd_image = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  }
  
			}
  
  if(isset($_FILES['cat_pd_hv_image']) && ($_FILES['cat_pd_hv_image']['size']['0']))
			{
  $errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/cat_pd_hv_image";
				
				$counter = 0;
				if($_FILES["cat_pd_hv_image"]["tmp_name"]!=""){
				foreach($_FILES["cat_pd_hv_image"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["cat_pd_hv_image"]["tmp_name"][$key];
                    $time =time();
					$cat_pd_hv_image =  $time.$_FILES["cat_pd_hv_image"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($cat_pd_hv_image, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $cat_pd_hv_image." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$cat_pd_hv_image) == true){
						$UploadOk = false;
						array_push($errors, $cat_pd_hv_image." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$cat_pd_hv_image);
						array_push($uploadedFiles, $cat_pd_hv_image);
					}
				}
				}
				

  if(count($uploadedFiles)>0){

 $cat_pd_hv_image = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  }

			}
			
if(isset($_FILES['cat_pd_pdf_image']) && ($_FILES['cat_pd_pdf_image']['size']['0']))
			{			
$errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/cat_pd_pdf_image";
				
				$counter = 0;
				if($_FILES["cat_pd_pdf_image"]["tmp_name"]!=""){
				foreach($_FILES["cat_pd_pdf_image"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["cat_pd_pdf_image"]["tmp_name"][$key];
                    $time =time();
					$cat_pd_pdf_image =  $time.$_FILES["cat_pd_pdf_image"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($cat_pd_pdf_image, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $cat_pd_pdf_image." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$cat_pd_pdf_image) == true){
						$UploadOk = false;
						array_push($errors, $cat_pd_pdf_image." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$cat_pd_pdf_image);
						array_push($uploadedFiles, $cat_pd_pdf_image);
					}
				}
				
				}

  if(count($uploadedFiles)>0){

 $cat_pd_pdf_image = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  }
  
			}
  
 			
if(isset($_FILES['cat_pd_video']) && ($_FILES['cat_pd_video']['size']['0']))
			{	 
  
$errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/cat_pd_video";
				
				$counter = 0;
				if($_FILES["cat_pd_video"]["tmp_name"]!=""){
				foreach($_FILES["cat_pd_video"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["cat_pd_video"]["tmp_name"][$key];
                    $time =time();
					$cat_pd_video =  $time.$_FILES["cat_pd_video"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($cat_pd_video, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $cat_pd_video." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$cat_pd_video) == true){
						$UploadOk = false;
						array_push($errors, $cat_pd_video." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$cat_pd_video);
						array_push($uploadedFiles, $cat_pd_video);
					}
				}
				
				}

  if(count($uploadedFiles)>0){

 $cat_pd_video = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  }
			}

 if(isset($_FILES['ic_image']) && ($_FILES['ic_image']['size']['0']))
			{
$errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/ic_image";
				
				$counter = 0;
				
				if($_FILES["ic_image"]["tmp_name"]!=""){
				foreach($_FILES["ic_image"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["ic_image"]["tmp_name"][$key];
                    $time =time();
					$ic_image =  $time.$_FILES["ic_image"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($ic_image, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $ic_image." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$ic_image) == true){
						$UploadOk = false;
						array_push($errors, $ic_image." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$ic_image);
						array_push($uploadedFiles, $ic_image);
					}
				}
				
				}
				

  if(count($uploadedFiles)>0){

 $ic_image = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  } 
	
			}
			
if(isset($_FILES['hd_image']) && ($_FILES['hd_image']['size']['0']))
			{
$errors = array();
				$uploadedFiles = array();
				$extension = array("jpeg","jpg","png","gif");
				$UploadFolder = "uploads/service/hd_image";
				
				$counter = 0;
				if($_FILES["hd_image"]["tmp_name"]!=""){
				foreach($_FILES["hd_image"]["tmp_name"] as $key=>$tmp_name){
					$temp = $_FILES["hd_image"]["tmp_name"][$key];
                    $time =time();
					$hd_image =  $time.$_FILES["hd_image"]["name"][$key];
					
					if(empty($temp))
					{
						break;
					}
					
					$counter++;
					$UploadOk = true;
					
						
					$ext = pathinfo($hd_image, PATHINFO_EXTENSION);
					if(in_array($ext, $extension) == false){
						$UploadOk = false;
						array_push($errors, $hd_image." is invalid file type.");
					}
					
					if(file_exists($UploadFolder."/".$hd_image) == true){
						$UploadOk = false;
						array_push($errors, $hd_image." file is already exist.");
					}
					
					if($UploadOk == true){
						move_uploaded_file($temp,$UploadFolder."/".$hd_image);
						array_push($uploadedFiles, $hd_image);
					}
				}
				}
				

  if(count($uploadedFiles)>0){

 $hd_image = implode ("," , $uploadedFiles);

/* foreach($uploadedFiles as $fileName)
{
	echo $fileName;
} */
  }
 
			}
			
if($_GET['backid']=='0'){


$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{

$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',category_id='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";


if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  

   }
}
}

if(($_GET['proid'])&&($_GET['backid']>0)){
	

	
	$dataq="SELECT * FROM cat_service";
	if($sql_select = $conn->query($dataq))
				{
					if($sql_select->num_rows>0)
					{
						while($resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC))
						{
							
						
	
if(($resultinfo['category_id']==$_GET['backid']) && ($resultinfo['id']==$_GET['proid'])) 
{
		$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{

$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',category_id='".$_GET['backid']."',sub_category_id='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";


if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				} 
  }				
}

}else if (($resultinfo['sub_category_id']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
		$checkDuplicate ="";

		$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

		$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
		if($sql_duplicate=$conn->query($query_duplicate))
		{
		if($sql_duplicate->num_rows>0)
		{
		$sess_msg= "This Title is already exist, please try another.";
		}
		else
		{

	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id='".$_GET['backid']."',sub_category_id1='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  

		}
	}
}
else if (($resultinfo['sub_category_id1']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
		$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{

	
	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id1='".$_GET['backid']."',sub_category_id2='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  
				
    }
}
}
else if (($resultinfo['sub_category_id2']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
		$checkDuplicate ="";

		$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

		$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
		if($sql_duplicate=$conn->query($query_duplicate))
		{
		if($sql_duplicate->num_rows>0)
		{
		$sess_msg= "This Title is already exist, please try another.";
		}
		else
		{

	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id2='".$_GET['backid']."',sub_category_id3='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  
				
		}

}
}
else if (($resultinfo['sub_category_id3']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
		$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{


	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id3='".$_GET['backid']."',sub_category_id4='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  
    }
}
}
else if (($resultinfo['sub_category_id4']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
		$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{


	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id4='".$_GET['backid']."',sub_category_id5='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  
				
   }

}
}
else if (($resultinfo['sub_category_id5']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
	 	$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{

	
	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id5='".$_GET['backid']."',sub_category_id6='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  
				
    }

}
}
else if (($resultinfo['sub_category_id6']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
	 
	 	$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{

	
	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id6='".$_GET['backid']."',sub_category_id7='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				}  
				
    }

}
}
else if (($resultinfo['sub_category_id7']==$_GET['backid'])&& ($resultinfo['id']==$_GET['proid'])) 
{
	 	$checkDuplicate ="";

$checkDuplicate = "AND id!='".$_GET['proid']."'"; 

$query_duplicate="SELECT * FROM cat_service WHERE ct_pd_name='".$ct_pd_name."' $checkDuplicate";
if($sql_duplicate=$conn->query($query_duplicate))
{
if($sql_duplicate->num_rows>0)
{
$sess_msg= "This Title is already exist, please try another.";
}
else
{

	$query_insert="INSERT INTO cat_service SET ct_pd_name='".$ct_pd_name."',sub_category_id7='".$_GET['backid']."',sub_category_id8='".$_GET['proid']."',ic_image='".$ic_image."',hd_image='".$hd_image."',ct_pd_url='".$ct_pd_url."',ct_pd_sl='".$ct_pd_sl."',ct_pd_title='".$ct_pd_title."',ct_pd_ky='".$ct_pd_ky."',ct_pd_mt_ds='".$ct_pd_mt_ds."',hd_sl_image='".$hd_sl_image."',zoom_image_width='".$zoom_image_width."',zoom_image_height='".$zoom_image_height."',home_pd_width='".$home_pd_width."',home_pd_height='".$home_pd_height."',pd_dl_width='".$pd_dl_width."',pd_dl_height='".$pd_dl_height."',cust_img_width='".$cust_img_width."',cust_img_height='".$cust_img_height."',sm_image_width='".$sm_image_width."',sm_image_height='".$sm_image_height."',tmb_width='".$tmb_width."',tmb_height='".$tmb_height."',cat_pd_image='".$cat_pd_image."',cat_pd_hv_image='".$cat_pd_hv_image."',cat_pd_pdf_image='".$cat_pd_pdf_image."',cat_pd_video='".$cat_pd_video."',cat_pd_mrp='".$cat_pd_mrp."',cat_pd_price='".$cat_pd_price."',cat_pd_dist='".$cat_pd_dist."',cat_pd_dist_amt='".$cat_pd_dist_amt."',cat_pd_sale_price='".$cat_pd_sale_price."',cat_pd_usd_mrp='".$cat_pd_usd_mrp."',cat_pd_usd_price='".$cat_pd_usd_price."',cat_pd_usd_dist='".$cat_pd_usd_dist."',cat_pd_dist_usd_amt='".$cat_pd_dist_usd_amt."',cat_pd_sale_usd_price='".$cat_pd_sale_usd_price."',quantity='".$quantity."',stock='".$stock."',small_description='".$small_description."',long_description='".$long_description."',free_return='".$free_return."',warranty='".$warranty."',shipping='".$shipping."',dilivery='".$dilivery."',support_number='".$support_number."',support_email='".$support_email."',status='".$status."'";
	
if($sql_insert=$conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$sess_msg = $pagename." Added Successfully.";
				} 

}				

}
}
}
}
						
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <section class="content">
      <div class="row">
       <div class="col-md-12">
          <div class="main-title">
		   <?php if($sess_msg!="") { ?> <h3 class="h5-headn hegt-96" style="color:red;"><?php echo $sess_msg; ?></h3> <?php } else { ?>
						 <h3>Add Category/service</h3>
						<?php } ?>
          
           </div>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
               <div class="col-md-4">
                <label class="input-text">Cate/Prod Name</label>
                  <div class="form-group">
                      <input type="text" name="ct_pd_name" value="<?php echo $ct_pd_name; ?>" required class="from-control custom-type">
                   </div>
                  </div>
                 <div class="col-md-4">
                  <label class="input-text">Cate/Prod Own URL</label>
                   <div class="form-group">
                      <input type="text" name="ct_pd_url" value="<?php echo $ct_pd_url; ?>" readonly style="cursor: not-allowed; opacity: 1;background-color: #eee" class="from-control custom-type">
                   </div>
                  </div>
                  <div class="col-md-4 mt-5">
                   <button type="submit" name="submit" value="add" class="btn btn-submit">Create</button>   
                  </div>
                  </div>
                  <div class="row">
                   <div class="col-md-6">
				  <label class="input-text">Status</label>
                      <br>
                      <br>
                   <input type="checkbox" required class="form-control" name="status[]" id="status" value="1" <?php if($status==  1) { echo "checked"; } ?>/>
				<div id="status_status"></div>
                  </div>
                 <div class="col-md-4">
                <label class="input-text">Cate/Prod Slogan</label>
                  <div class="form-group">
                      <input type="text" name="ct_pd_sl" value="<?php echo $ct_pd_sl; ?>" class="from-control custom-type" placeholder="Cate/Prod Slogan">
                   </div>
                  </div> 
                 <div class="col-md-4">
                <label class="input-text">Cate/Prod Title</label>
                  <div class="form-group">
                      <input type="text" name="ct_pd_title" value="<?php echo $ct_pd_title; ?>" class="from-control custom-type" placeholder="Cate/Prod Title">
                   </div>
                  </div> 
                <div class="col-md-4">
                <label class="input-text">Cate/Prod Keyword</label>
                  <div class="form-group">
                      <input type="text" name="ct_pd_ky" value="<?php echo $ct_pd_ky; ?>" class="from-control custom-type" placeholder="Cate/Prod Keyword">
                   </div>
                  </div> 
                    
                 <div class="col-md-12">
                 <label class="input-text">Cate/Prod Meta Description</label>
                  <div class="form-group">
                      <textarea name="ct_pd_mt_ds" class="from-control custom-type" placeholder="Page Meta Description" rows="5" cols="5"><?php echo $ct_pd_mt_ds; ?></textarea>
                   </div>
                  </div> 
                <div class="col-md-4">
                <label class="input-text">Icon Image</label>
                  <div class="form-group">
				   <?php if($ic_image!="") { ?>
					<img src="uploads/service/ic_image/<?php echo $ic_image;?>" height="100" width="120">
					<?php } ?>
                      <input type="file" name="ic_image[]" value="<?php echo $ic_image; ?>" class="form-control custom-type"  multiple >
                   </div>
                  </div>   
                <div class="col-md-4">
                <label class="input-text">Header Image</label>
                  <div class="form-group">
				    <?php if($hd_image!="") { ?>
					<img src="uploads/service/hd_image/<?php echo $hd_image; ?>" height="100" width="120">
					<?php } ?>
                      <input type="file" name="hd_image[]" value="<?php echo $hd_image; ?>" class="form-control custom-type"  multiple >
                   </div>
                  </div> 
                     <div class="col-md-4">
                <label class="input-text">Header Slider Image</label>
                  <div class="form-group">
				    <?php if($hd_sl_image!="") { ?>
					<img src="uploads/service/hd_sl_image/<?php echo $hd_sl_image; ?>" height="100" width="120">
					<?php } ?>
                      <input type="file" name="hd_sl_image[]" class="form-control custom-type"  multiple >
                   </div>
                  </div>   
                  </div>
                   <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12 marginpadding0  cl-r">
            	
               	<div class="col-md-2 ">
                    <label class="input-text">Zoom Image</label>
                    </div>
                <div class="col-md-2 ">
                    <label class="input-text">Home &amp; service Image</label>
                    </div>
                <div class="col-md-2">
                    <label class="input-text">service Detail Image</label>
                    </div>
                  <div class="col-md-2 ">
                      <label class="input-text">Customized Image</label>
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
          <input type="text" size="4" placeholder="Width" name="zoom_image_width" value="<?php echo $zoom_image_width; ?>">
          <input type="text" size="4" placeholder="Height" name="zoom_image_height" value="<?php echo $zoom_image_height; ?>">
           </div>
        <div class="col-md-2 from-txt ">
            <input type="text" size="4" placeholder="Width" name="home_pd_width" value="<?php echo $home_pd_width; ?>">
          <input type="text" size="4" placeholder="Height" name="home_pd_height" value="<?php echo $home_pd_height; ?>">
            </div>
          <div class="col-md-2 from-txt ">
           
          <input type="text" size="4" placeholder="Width" name="pd_dl_width" value="<?php echo $pd_dl_width; ?>">
           <input type="text" size="4" placeholder="Height" name="pd_dl_height" value="<?php echo $pd_dl_height; ?>">
        
         
          </div>
          
          <div class="col-md-2 from-txt ">
           
         <input type="text" size="4" placeholder="Width" name="cust_img_width" value="<?php echo $cust_img_width; ?>">
          <input type="text" size="4" placeholder="Height" name="cust_img_height" value="<?php echo $cust_img_height; ?>">
         
          </div>
          
         <div class="col-md-2 from-txt ">
           <input type="text" size="4" placeholder="Width" name="sm_image_width" value="<?php echo $sm_image_width; ?>">
          <input type="text" size="4" placeholder="Height" name="sm_image_height" value="<?php echo $sm_image_height; ?>">
          </div>
        <div class="col-md-2 from-txt ">
          <input type="text" size="4" placeholder="Width" name="tmb_width" value="<?php echo $tmb_width; ?>">
          <input type="text" size="4" placeholder="Height" name="tmb_height" value="<?php echo $tmb_height; ?>">
		</div>
        
            </div>
                      </div>
                  <div class="row">
                    <div class="col-md-3">
                <label class="input-text">Cate/Prod Image</label>
                  <div class="form-group">
				    <?php if($cat_pd_image!="") { ?>
					<img src="uploads/service/cat_pd_image/<?php echo $cat_pd_image; ?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="cat_pd_image[]" class="form-control custom-type"   multiple >
                   </div>
                  </div>   
                <div class="col-md-3">
                <label class="input-text">Cate/Prod Hover Image</label>
                  <div class="form-group">
				    <?php if($cat_pd_hv_image!="") { ?>
					<img src="uploads/service/cat_pd_hv_image/<?php echo $cat_pd_hv_image; ?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="cat_pd_hv_image[]" class="form-control custom-type"  multiple>
                   </div>
                  </div> 
                <div class="col-md-3">
                <label class="input-text">Cate/Prod PDF (Upload)</label>
                  <div class="form-group">
				     <?php if($cat_pd_pdf_image!="") { ?>
					<img src="uploads/service/cat_pd_pdf_image/<?php echo $cat_pd_pdf_image; ?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="cat_pd_pdf_image[]" class="form-control custom-type"  multiple>
                   </div>
                  </div> 
                 <div class="col-md-3">
                <label class="input-text">Cate/Prod Video</label>
                  <div class="form-group">
				    <?php if($cat_pd_video!="") { ?>
					<img src="uploads/service/cat_pd_video/<?php echo $cat_pd_video; ?>" height="100" width="120" >
					<?php } ?>
                      <input type="file" name="cat_pd_video[]" class="form-control custom-type"  multiple>
                   </div>
                  </div> 
                      
                <div class="col-row">
                      <div class="col-md-2">
                     <h5 class="cat-pro-heading">Cate/Prod Price</h5>
                    </div>
                      <div class="col-md-2">
             
                  <div class="form-group">
                      <input type="text" name="cat_pd_mrp" id="cat_pd_mrp"  value="<?php echo $cat_pd_mrp; ?>" class="from-control custom-type" placeholder="Cate/Prod MRP" onkeypress="return isNumberKey(event)">
                   </div>
                  </div> 
                     <div class="col-md-2">
             
                  <div class="form-group">
                      <input type="text" name="cat_pd_price" id="cat_pd_price" value="<?php echo $cat_pd_price; ?>" class="from-control custom-type" placeholder="Cate/Prod Price" onkeypress="return isNumberKey(event)">
                   </div>
                  </div> 
                     <div class="col-md-2">
                
                  <div class="form-group">
                      <input type="text" name="cat_pd_dist" id="cat_pd_dist" value="<?php echo $cat_pd_dist; ?>" class="from-control custom-type" placeholder="Discount Price(%)" onkeypress="return isNumberKey(event)">
                   </div>
                  </div> 
                     <div class="col-md-2">
              
                  <div class="form-group">
                      <input type="text" name="cat_pd_dist_amt" id="cat_pd_dist_amt" value="<?php echo $cat_pd_dist_amt; ?>" class="from-control custom-type" placeholder="Discount Amount" readonly style="cursor: not-allowed; opacity: 1;background-color: #eee">
                   </div>
                  </div> 
                     <div class="col-md-2">
               
                  <div class="form-group">
                      <input type="text" name="cat_pd_sale_price" id="cat_pd_sale_price" value="<?php echo $cat_pd_sale_price; ?>" class="from-control custom-type" placeholder="Cate/Prod Sell Price" readonly style="cursor: not-allowed; opacity: 1;background-color: #eee">
                   </div>
                  </div> 
                    
                      </div>      
                          <div class="col-row">
                      <div class="col-md-2">
                     <h5 class="cat-pro-heading2">service Price(USD)</h5>
                    </div>
                      <div class="col-md-2">
          
                  <div class="form-group">
                      <input type="text" name="cat_pd_usd_mrp" id="cat_pd_usd_mrp" value="<?php echo $cat_pd_usd_mrp; ?>" class="from-control custom-type" placeholder="service USD MRP" onkeypress="return isNumberKey(event)">
                   </div>
                  </div> 
                     <div class="col-md-2">
               
                  <div class="form-group">
                      <input type="text" name="cat_pd_usd_price" id="cat_pd_usd_price" value="<?php echo $cat_pd_usd_price; ?>" class="from-control custom-type" placeholder="Cate/Prod Price" onkeypress="return isNumberKey(event)">
                   </div>
                  </div> 
                     <div class="col-md-2">
               
                  <div class="form-group">
                      <input type="text" name="cat_pd_usd_dist" id="cat_pd_usd_dist" value="<?php echo $cat_pd_usd_dist; ?>" class="from-control custom-type" placeholder="0" onkeypress="return isNumberKey(event)">
                   </div>
                  </div> 
                     <div class="col-md-2">
              
                  <div class="form-group">
                      <input type="text" name="cat_pd_dist_usd_amt" id="cat_pd_dist_usd_amt" value="<?php echo $cat_pd_dist_usd_amt; ?>" class="from-control custom-type" placeholder="0"  readonly style="cursor: not-allowed; opacity: 1;background-color: #eee">
                   </div>
                  </div> 
                     <div class="col-md-2">
                  <div class="form-group">
                      <input type="text" name="cat_pd_sale_usd_price" id="cat_pd_sale_usd_price" value="<?php echo $cat_pd_sale_usd_price; ?>" class="from-control custom-type" placeholder="0" readonly style="cursor: not-allowed; opacity: 1;background-color: #eee">
                   </div>
                  </div> 
                 <div class="col-md-6">
                <label class="input-text">Minimum Sale Quantity</label>
                  <div class="form-group">
                      <input type="text" name="quantity" value="<?php echo $quantity; ?>" class="form-control custom-type"  placeholder="0">
                   </div>
                  </div>  
                 <div class="col-md-6">
                <label class="input-text">Stock Status</label>
                  <div class="form-group">
                      <select name="stock" class="form-control custom-type" >
                      <option <?php if($stock==""){echo "selected"; } ?> value="">select an option</option>
                      <option <?php if($stock=="in_stock"){echo "selected"; } ?> value="in_stock">In Stock</option>
                      <option <?php if($stock=="out_in_stock"){echo "selected"; } ?> value="out_in_stock"> Out of stock</option>
                      </select>
                   </div>
                  </div>                
                      </div>     
                <div class="col-md-12">
                 <label class="input-text">Cate/Prod Small Description</label>
                  <div class="form-group">
                      <textarea name="small_description" class="from-control custom-type" placeholder="Cate/Prod Small Description" rows="5" cols="5"><?php echo $small_description; ?></textarea>
                   </div>
                  </div>  
                      
                    <div class="col-md-12">
                  <label class="input-text">Cate/Prod Description</label>
				  <div class="form-group">
                      <textarea name="long_description" id="long_description" class="ckeditor" class="from-control custom-type" placeholder="Page Description" rows="5" cols="5"><?php echo $long_description;?></textarea>
                   </div>
                 
               
                 </div>
                <br>
                 <div class="row purchase-section">     
                 <div class="col-md-3">
                <label class="input-text">Days Free Returns / Exchange</label>
                  <div class="form-group">
                      <input type="text" class="form-control custom-type" value="<?php echo $free_return; ?>" name="free_return" placeholder="enter only days">
                   </div>
                  </div>  
                <div class="col-md-3">
                <label class="input-text">Warranty</label>
                  <div class="form-group">
                      <input type="text" class="form-control custom-type" value="<?php echo $warranty; ?>" name="warranty" placeholder="service Warranty">
                   </div>
                  </div>  
                <div class="col-md-3">
                <label class="input-text">Shipping</label>
                  <div class="form-group">
                      <input type="text" class="form-control custom-type" value="<?php echo $shipping; ?>" name="shipping" placeholder="Shipping">
                   </div>
                  </div>  
                <div class="col-md-3">
                <label class="input-text">Delivery</label>
                  <div class="form-group">
                      <input type="text" class="form-control custom-type" value="<?php echo $dilivery; ?>" name="dilivery" placeholder="Delivery">
                   </div>
                  </div>  
                <div class="col-md-3">
                <label class="input-text">Support Number</label>
                  <div class="form-group">
                      <input type="text" class="form-control custom-type" value="<?php echo $support_number; ?>" name="support_number" placeholder="Support Number">
                   </div>
                  </div>  
                 <div class="col-md-3">
                <label class="input-text">Support Email</label>
                  <div class="form-group">
                      <input type="text" class="form-control custom-type" value="<?php echo $support_email; ?>" name="support_email" placeholder="Support Email">
                   </div>
                  </div>  
               
				  
                  <div class="col-md-12">
                   <button type="submit" name="submit" value="add" class="btn btn-submit">Sbumit</button>                            
                  </div>
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
<link rel="stylesheet" href="lib/ToggleSwitch.css"/>
<script src="lib/ToggleSwitch.js"></script>
<script>
$(function(){
$("#status").toggleSwitch();
$("#myonoffswitch2").toggleSwitch();
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
        data: {'id': ids ,'remove_service':'action'} ,
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
<script language="javascript" type="text/javascript">
function isNumberKey(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
		 //onKeyPress="return isNumberKey(event)"
      };
</script>

<script>


$(document).ready(function(){
$("#cat_pd_mrp").blur(function(){
	var mrp=$("#cat_pd_mrp").val();
	$("#cat_pd_dist").val(0);
	$("#cat_pd_dist_amt").val(0);
	$("#cat_pd_price").val(mrp);
	$("#cat_pd_sale_price").val(mrp);
	});
});

$(document).ready(function(){
$("#cat_pd_price").blur(function(){
	var price=$("#cat_pd_price").val();
	$("#cat_pd_dist_amt").val(0);
	$("#cat_pd_dist_amt").val(0);
	$("#cat_pd_sale_price").val(price);
	});
});

$(document).ready(function(){
$("#cat_pd_dist").blur(function(){
	var mrp=$("#cat_pd_mrp").val();
	var price=$("#cat_pd_price").val();
	var discount=$("#cat_pd_dist").val();
	var discountAmount=Number(price)*Number(discount)/100;
	var finalAmount=Number(price)-Number(discountAmount);
	$("#cat_pd_dist_amt").val(discountAmount);
	$("#cat_pd_sale_price").val(finalAmount.toFixed(2));
	});
});


$(document).ready(function(){
$("#cat_pd_usd_mrp").blur(function(){
	var mrp=$("#cat_pd_usd_mrp").val();
	$("#cat_pd_usd_dist").val(0);
	$("#cat_pd_dist_usd_amt").val(0);
	$("#cat_pd_usd_price").val(mrp);
	$("#cat_pd_sale_usd_price").val(mrp);
	});
});

$(document).ready(function(){
$("#cat_pd_usd_price").blur(function(){
	var price=$("#cat_pd_usd_price").val();
	$("#cat_pd_usd_dist").val(0);
	$("#cat_pd_dist_usd_amt").val(0);
	$("#cat_pd_sale_usd_price").val(price);
	});
});

$(document).ready(function(){
$("#cat_pd_usd_dist").blur(function(){
	var mrp=$("#cat_pd_usd_mrp").val();
	var price=$("#cat_pd_usd_price").val();
	var discount=$("#cat_pd_usd_dist").val();
	var discountAmount=Number(price)*Number(discount)/100;
	var finalAmount=Number(price)-Number(discountAmount);
	$("#cat_pd_dist_usd_amt").val(discountAmount);
	$("#cat_pd_sale_usd_price").val(finalAmount.toFixed(2));
	});
});
</script>

<script src="plugins/ckeditor/ckeditor.js"></script>
</body>
</html>
