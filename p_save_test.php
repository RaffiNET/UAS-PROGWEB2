<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("test_looping_insert",$conn); 


for ($i = 1;$i<=$_POST['banyak'];$i++) {
    $value='qty'.$i;
    $data = $_POST[$value];
    mysql_query("INSERT INTO barang (qty) VALUES ('$data')");
}