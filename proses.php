<?php
$conn = mysqli_connect("localhost","progra12_elan","palapeyang926","progra12_bengkel");

$id_mekanik = $_POST['id_mekanik'];
$id_sparepart = $_POST['id_sparepart'];
$id_pelanggan = $_POST['id_pelanggan'];
$qty = $_POST['qty'];
$harga_jasa = $_POST['harga_jasa'];
$diskon=$_POST['diskon'];
$tgl_beli = $_POST['tgl_beli'];

$pembelian=mysqli_query($conn, "INSERT INTO 213_pembelian (id_mekanik, id_pelanggan, harga_jasa, tgl_beli)
VALUES ('$id_mekanik', '$id_pelanggan', '$harga_jasa', '$tgl_beli')"); 

if($pembelian){
    $id_pembelian=mysqli_insert_id($conn);
    $total = count($id_sparepart);
    
    for($i=0; $i<$total; $i++){

        mysqli_query($conn, "INSERT INTO 213_pembelian_detail (id_pembelian, id_sparepart, qty,diskon)
        VALUES ('$id_pembelian', '$id_sparepart[$i]', '$qty[$i]','$diskon[$i]')");
    }

    // var_dump($id_sparepart);
    
    header("location: pembelian.php");
}else{
    echo("Error description: " . $conn -> error);
}


mysqli_close($conn);

?>
 


