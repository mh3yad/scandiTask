<?php

    
function cors(){
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
}

cors();

spl_autoload_register(function ($class_name) {
    if(file_exists("./model/$class_name.php"))
    {
        require_once "./model/$class_name.php";
    }
    else if(file_exists("./controllers/$class_name.php"))
    {
        require_once "./controllers/$class_name.php";
    }
});

$action='';
if (isset($_GET['action'])) {
	
	$action=$_GET['action'];
}
if($action=='addProduct'){


	$type = $_POST['product_type'];
    $_POST['attributes'] = json_decode($_POST['attributes']);
	 $product = new $type($_POST);
     $result = $product->productValidate($_POST);
     if($result===true){
	 	$res['error']=false;
         $res['message']="User Added Successfully";
	 }else{
	 	$res['error']=true;
         $res['message']=$result;
	 }

}
else if($action=='getTypes'){

	$result = Product::getTypes();
	if($result->num_rows > 0){
		while($row =mysqli_fetch_assoc($result))
		{
			$res[] = $row;
		}


	}else{
		$res['error']=true;
        $res['message']=$result;
	}

}else if($action == 'getAll'){
    $result = Product::all();
    if(empty($result)){
        $res = 'empty';
    }else {
        foreach ($result as $row) {

            $res[] = $row;
        }
    }
}


else if($action == 'getAttributes'){
    $result = Product::getAttributes($_GET['id']);
	if($result->num_rows > 0){
		while($row =mysqli_fetch_assoc($result))
		{
			$res[] = $row;
		}


	}else{
		$res['error']=true;
        $res['message']=$result;
	}
}else if($action = 'delete'){
    $arr = explode(",",$_POST['toDeleteArray']);
    print_r($arr);
    foreach ($arr as $id) {
        echo $id . " $$  ";
        $res  =  Product::delete($id);
        $res= 'success';
    }
}

 header("Content-type: application/json");
 echo json_encode($res,JSON_FORCE_OBJECT);
 die();
 ?>