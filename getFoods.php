<?php

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "db_order_food"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

$id_restoran = 0;

if(isset($_POST['restoran'])){
   $id_restoran = mysqli_real_escape_string($con,$_POST['restoran']); // department id
}

$food_arr = array();

if($id_restoran > 0){
    $sql = "SELECT id_food,nama_makanan,harga FROM tb_food WHERE id_restoran=".$id_restoran;

    $result = mysqli_query($con,$sql);
    
    while( $row = mysqli_fetch_array($result) ){
        $foodid = $row['id_food'];
        $nama_makanan = $row['nama_makanan'];
        $harga=$row['harga'];
    
        $food_arr[] = array("food_id" => $foodid, "nama_makanan" => $nama_makanan,"harga"=>$harga);
    }
}

// encoding array to json format
echo json_encode($food_arr);