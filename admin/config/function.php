<?php

include 'conn.php';

date_default_timezone_set('Asia/Kolkata');

    global $created_at;

    $created_at=date('Y-m-d H:i:s');



function admin_base_url()

{

  return sprintf(

    "%s://%s",

    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',

    $_SERVER['SERVER_NAME'].'/dynamic/avikrrit/admin/'

    //$_SERVER['REQUEST_URI']

  );

}

function base_url()

{

  return sprintf(

    "%s://%s",

    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',

    $_SERVER['SERVER_NAME'].'/dynamic/avikrrit/'

    //$_SERVER['REQUEST_URI']

  );

}





function insert_data($tblname,$form_data)

{

    global $conn;

    $fields = array_keys($form_data);

    //print_r($form_data);

$sql="INSERT INTO `".$tblname."`(`".implode("`,`", $fields)."`)  VALUES('".implode("','", $form_data)."')";  



    $query= mysqli_query($conn,$sql) or mysqli_error($conn);;

    if($query){

            return mysqli_insert_id($conn);

    }else{

        return false;

    }

}



function check_data_exist($tablename,$condi)

{

    global $conn;

    print_r($condi);

    if(!empty($condi))

    {

            foreach ($condi as $key => $value) 

            {

               echo $cond="WHERE `".$key."`= '".$value."'";                

            }

            

    }

       //echo  $sql="SELECT * FROM `$tablename` $cond AND `status`=1";

       echo $sql="SELECT * FROM `$tablename` $cond";

        $query=mysqli_query($conn,$sql) or die(mysqli_error($conn));

        return $count=mysqli_num_rows($query);

        // if($count>0)

        // {

        //     return true;

        // }else{

        //     return false;

        // }

}



function edit_data($tblname,$form_data,$field_id,$id)

{

   global $conn;

    $sql = "UPDATE ".$tblname." SET ";

    $data = array();

    foreach($form_data as $column=>$value){

        $data[] =$column."="."'".$value."'";

    }

    $sql .= implode(',',$data);

     $sql.=" where ".$field_id." = ".$id."";

     

     $query=mysqli_query($conn,$sql) or die(mysqli_error($conn));

     if($query)

     {

                return true;

     }else{

        return false;

     }

}



 function get_data($tablename,$condi=null,$operator=null,$orderby=null,$limit=null)

    {

    

            global $conn;

    if(is_array($condi) && !empty($condi))

    {

            foreach ($condi as $key => $value) 

            {

                $cond[]="`".$key."`".$operator." '".$value."'";                

            }

            

            if(!empty($limit))

            {

                $limits=" LIMIT ".$limit;

            }else{

                $limits="";

            }
            if(!empty($orderby))
            {
                $order="ORDER BY 'id' ".$orderby;
            }else{
                $order="";
            }

       //echo  $sql="SELECT * FROM `$tablename` $cond AND `status`=1";

       $sql="SELECT * FROM `$tablename` WHERE";
        $sql .= implode('AND',$cond);
        $sql .= $order ;
         $sql .= $limits;

      

       //$sql.=" ";

        $query=mysqli_query($conn,$sql) or die(mysqli_error($conn));

        

               // $data=mysqli_fetch_assoc($query);

                //return $data;

            }else{

                $sql="SELECT * FROM `$tablename`";

                $query=mysqli_query($conn,$sql) or die(mysqli_error($conn));

               }

                $all_data=array();

                while($row=mysqli_fetch_assoc($query))

            {

                    $all_data[]=$row;

            }

                return $all_data;

             

    }



function data_count($tablename,$condi=null,$operator=null)

    {

    

            global $conn;

    if(is_array($condi) && !empty($condi))

    {

            foreach ($condi as $key => $value) 

            {

                $cond[]="`".$key."`".$operator." '".$value."'";                

            }

            

    

       //echo  $sql="SELECT * FROM `$tablename` $cond AND `status`=1";

       $sql="SELECT * FROM `$tablename` WHERE";

        $sql.=implode('AND',$cond);

       //$sql.=" ";

       

        $query=mysqli_query($conn,$sql) or die(mysqli_error($conn));

        

               // $data=mysqli_fetch_assoc($query);

                //return $data;

            }else{

                $sql="SELECT * FROM `$tablename`";

                $query=mysqli_query($conn,$sql) or die(mysqli_error($conn));

               }

               $all_data=mysqli_num_rows($query);

            //     $all_data=array();

            //     while($row=mysqli_fetch_assoc($query))

            // {

            //         $all_data[]=$row;

            // }

                return $all_data;

             

    }

class wine

{	



	function logo($conn,$table,$field)

	{

		$querylogo = "SELECT $field FROM `$table` WHERE status = 1 ORDER BY id DESC";

		if($sql_selectlogo = $conn->query($querylogo))

		{

			if($sql_selectlogo->num_rows>0)

			{

				$resultlogo = $sql_selectlogo->fetch_array(MYSQLI_ASSOC);

				return trim($resultlogo[$field]);

			}

		}

	}

		function getstatus($conn,$table)

	{

		$querystatus = "SELECT * FROM `$table` WHERE status = 1";

		if($sql_selectstatus = $conn->query($querystatus))

		{

		$num=$sql_selectstatus->num_rows;

		return $num;

		}

	}

		function getall($conn,$table)

	{

		$queryall = "SELECT * FROM `$table`";

		if($sql_selectall = $conn->query($queryall))

		{

		$numall=$sql_selectall->num_rows;

		return $numall;

		}

	}

	



    	function getstatus1($conn,$table)

	{

		$querystatus1 = "SELECT * FROM `$table` WHERE status = 0";

		if($sql_selectstatus1 = $conn->query($querystatus1))

		{

		$num1=$sql_selectstatus1->num_rows;

		return $num1;

		}

	}

	

	

	function getInfo($conn,$table,$field,$id)

	{

		$queryinfo = "SELECT $field FROM `$table` WHERE id = '".$id."'";

		if($sql_select = $conn->query($queryinfo))

		{

			if($sql_select->num_rows>0)

			{

				$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);

				return trim($resultinfo[$field]);

			}

		}		

	}

	

	

		function getInfo2($conn,$table,$alias)

	{

	 	$queryinfo2 = "SELECT * FROM `$table` WHERE alias = '".$alias."'";

		if($sql_select2 = $conn->query($queryinfo2))

		{

			if($sql_select2->num_rows>0)

			{

				$resultinfo2 = $sql_select2->fetch_array(MYSQLI_ASSOC);

				return $resultinfo2;

			}

		}		

	}

	

	



	function getdata($conn,$table,$field,$cond,$value)

	{

		$querydata = "SELECT $field FROM $table WHERE $cond = '".$value."' and status = '1'";

		if($sql_selectdata = $conn->query($querydata))

		{

			if($sql_selectdata->num_rows>0)

			{

				$resultdata = $sql_selectdata->fetch_array(MYSQLI_ASSOC);

				return trim($resultdata[$field]);

			}

		}

	}

	

	

	function getnewdata($conn,$table,$field,$cond,$value)

	{

		$query_data = "SELECT $field FROM $table WHERE $cond = '".$value."' ";

		if($sql_select_data = $conn->query($query_data))

		{

			if($sql_select_data->num_rows>0)

			{

				$result_data = $sql_select_data->fetch_array(MYSQLI_ASSOC);

				return trim($result_data[$field]);

			}

		}

	}

	

	function getallrecord($conn,$table)

	{

		$queryrecord = "SELECT * FROM `$table` WHERE status=1 ORDER BY id DESC";

		if($sql_selectrecord=$conn->query($queryrecord))

		{

			if($sql_selectrecord->num_rows>0)

			{

				$resultrecord=$sql_selectrecord->fetch_array(MYSQLI_ASSOC);

				return $resultrecord;

			}

		}

	}

	

	function getnumrows($conn,$table)

	{

		$querynumrows = "SELECT * FROM `$table` WHERE status=1";

		if($sql_selectnumrows = $conn->query($querynumrows))

		{

			$num = $sql_selectnumrows->num_rows;

			return $num;

		}

	}

	

	function getallrecords($conn,$table)

	{

		$queryrecords = "SELECT * FROM `$table` WHERE status=1 ORDER BY id DESC";

		if($sql_selectrecords=$conn->query($queryrecords))

		{

			return $sql_selectrecords;

		}

	}

	

	function getlimit($conn,$table,$limit)

	{

		$querylimit = "SELECT * FROM $table WHERE status=1 ORDER BY id DESC $limit";

		if($sql_selectlimit = $conn->query($querylimit))

		{

			return $sql_selectlimit;

		}

	}

	

	function getconlimit($conn,$table,$cond,$limit)

	{

		$queryconlimit = "SELECT * FROM $table WHERE $cond AND status=1 ORDER BY id DESC $limit";

		if($sql_selectconlimit = $conn->query($queryconlimit))

		{

			return $sql_selectconlimit;

		}

	}

	

	function getconrecords($conn,$table,$cond)

	{

		$queryconrecords = "SELECT * FROM $table WHERE $cond  ORDER BY id DESC";

		if($sql_selectconrecords=$conn->query($queryconrecords))

		{

			return $sql_selectconrecords;

		}

	}

	

	function getcolorrecords($conn,$table,$cond)

	{

		$querycolorrecords = "SELECT * FROM $table WHERE $cond GROUP BY id DESC";

		if($sql_selectcolorrecords=$conn->query($querycolorrecords))

		{

			return $sql_selectcolorrecords;

		}

	}

	

	function getconrecord($conn,$table,$cond)

	{

		$queryconrecord = "SELECT * FROM $table WHERE $cond AND status=1 ORDER BY id DESC";

		if($sql_selectconrecord=$conn->query($queryconrecord))

		{			

			if($sql_selectconrecord->num_rows>0)

			{

				$resultconrecord = $sql_selectconrecord->fetch_array(MYSQLI_ASSOC);

				return $resultconrecord;

			}

		}

	}

	

	function getconimage($conn,$table,$field,$cond)

	{

		$queryconrecord = "SELECT $field FROM $table WHERE $cond ORDER BY id DESC";

		if($sql_selectconrecord=$conn->query($queryconrecord))

		{			

			if($sql_selectconrecord->num_rows>0)

			{

				$resultconrecord = $sql_selectconrecord->fetch_array(MYSQLI_ASSOC);

				return trim($resultconrecord[$field]);

			}

		}

	}

	

	function gettotalitem($conn,$session_id)

	{

		$queryitem="SELECT * FROM cart WHERE session_id='$session_id' && status=1";

		if($sql_selectitem=$conn->query($queryitem))	

		{

			$num=$sql_selectitem->num_rows;

			return $num;

		}

	}

	

}



$newobject = new wine();



?>