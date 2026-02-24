<?php
include('config/conn.php');


if(isset($_GET['id']))
{
	
	$id=$_GET['id'];
}

  $data=$_GET['data']; 


            $result = $conn->query("select * FROM cat_prod where id='$id'");

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); 
				
				$image = explode(",",$row['cat_pd_pdf_image']); 
				
				$key = array_search($data, $image);
				unset($image[$key]);
				$image1=  implode(",",$image);
				$path="uploads/product/cat_pd_pdf_image".$image1;
				unlink($path);
				     $sql="UPDATE cat_prod SET cat_pd_pdf_image='$image1' WHERE id='$id'"; 
                     $res=mysqli_query($conn,$sql);
			 if($res){
				      header('Location: add-products.php?id='.$id);
    }


	

    

} 



?>