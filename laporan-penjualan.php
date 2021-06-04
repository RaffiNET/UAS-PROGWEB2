<?php
session_start();
if(!isset($_SESSION['nama_pengguna'])){
	echo "<script>location.href='login.php'</script>";
}
 // Define relative path from this script to mPDF
 $nama_dokumen='Laporan Service'; //Beri nama file PDF hasil.
define('_MPDF_PATH','MPDF57/');
include(_MPDF_PATH . "mpdf.php");
$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
 
//Beginning Buffer to save PHP variables and HTML tags
ob_start(); 
?>
<!--sekarang Tinggal Codeing seperti biasanya. HTML, CSS, PHP tidak masalah.-->
<!--CONTOH Code START-->
<?php
 //KONEKSI
$host="localhost"; //isi dengan host anda. contoh "localhost"
$user="progra12_elan"; //isi dengan username mysql anda. contoh "root"
$password="palapeyang926"; //isi dengan password mysql anda. jika tidak ada, biarkan kosong.
$database="progra12_bengkel";//isi nama database dengan tepat.
mysql_connect($host,$user,$password);
mysql_select_db($database);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PDF INVOICE</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>

a {
  color: #5D6975;
  text-decoration: underline;
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

body {
  position: relative;
  width: 21cm;  
  /* height: 29.7cm;  */
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  width: 90px;
  float: right;
}

#logo img {
  width: 90px;


h1 {
  color: #00000;
  font-size: 2.4em;
  line-height: 20px;
  font-weight: normal;
  margin: 0 0 20px 0;
}
h4 {
  text-align: center;
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-spacing: 0;
  margin-bottom: 20px;
}
thead {background-color: #000080;}



table th,
table td {
  text-align: center;
  border: 0.5px solid black;
  
}

table th {
  border: 0.5px solid black;
  padding: 5px 20px;
  white-space: nowrap;        
  font-weight: normal;
  background-color: #4682B4;
  color: white;
}

table .service,
table .desc {
  text-align: center;
}

table td {
  padding: 20px;
  text-align: center;
}

table td.service,
table td.desc {
  vertical-align: top;
  text-align: center;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}
</style>
 </head>
  <body>
      <div id="logo">
        <img src="images/bengkel-dimas.png">
</div>
      <h1>DIMAS MOTOR</h1>
        <div><i>WE CARE YOUR CARS</i></div>
        <br>
        <div>PERUMAHAN MEKAR ASRI 1 BLOK B6/14<br>
            PANONGAN, BANTEN, TANGERANG 15710
            </div>
        <div>0851212236363367/08119341510</div>
      </div>
      <br>
      <hr>


    </header>
<h4>LAPORAN SERVICE</h4>
<p align="left">Nama Kasir: <?php echo $_SESSION['nama_pengguna'] ?></p>
<p align="left">Tanggal: <?php date_default_timezone_set("Asia/Jakarta"); echo $date = date('Y-m-d |  H:i:s'); ?> </p>

<table border="1">
<thead>
<tr>
<th>Nama Pelanggan</td>
<th>Sparepart</td>
<th>Qty</td>
<th>Harga Sparepart</td>
<th>Harga Jasa</td>
<th>Jumlah</td>
<th>Tanggal</td>


</tr>
</thead>
<?php 

$sql=mysql_query("select 213_sparepart.sparepart, 213_pembelian_detail.qty, 213_sparepart.harga from 213_pembelian_detail 
		INNER JOIN 213_sparepart ON 213_pembelian_detail.id_sparepart=213_sparepart.id_sparepart
		INNER JOIN 213_pembelian ON 213_pembelian_detail.id_pembelian=213_pembelian.id_pembelian
		ORDER BY 213_pembelian.id_pembelian DESC");
		while($data=mysql_fetch_array($sql)){
?>
<tbody>
<tr>
<td><?php echo $data['nama']?></td>
<td class="unit"><?php echo $data['sparepart']?></td>
<td class="qty"><?php echo $data['qty']?></td>
<td class="desc"><?php echo "Rp.".  number_format($data['harga'])?></td>
<td class="desc"><?php echo $data['harga_jasa']?></td>
<td>
<?php 
	$hs= $data['harga'];
	$qt= $data['qty'];
	$hj= $data['harga_jasa'];
	$tot = ($hs * $qt) + $hj;
	echo "Rp." . number_format("$tot");

			
			?>
</td>
<td><?php echo $data['tgl_beli']?></td>
</tr></tbody>';
<?php
}
?>
</table>
<br>
<br>
<br>

<!--CONTOH Code END-->
 <table border="0">
        <tr>
            <td align="center">Hormat Kami
							<br>
							<br>
							<br>
							(..............)</td>
			  <td align="center">Kepala bengkel
							<br>
							<br>
							<br>
							(..............)</td>
        </tr>
       
    </table>
 
<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
?>