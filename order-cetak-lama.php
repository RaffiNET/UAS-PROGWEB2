<?php
session_start();
if(!isset($_SESSION['nama_pengguna'])){
	echo "<script>location.href='login.php'</script>";
}
 // Define relative path from this script to mPDF

 $nama_dokumen='BUKTI PEMESANAN'; //Beri nama file PDF hasil.
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
$user="root"; //isi dengan username mysql anda. contoh "root"
$password=""; //isi dengan password mysql anda. jika tidak ada, biarkan kosong.
$database="db_order_food";//isi nama database dengan tepat.
$conn = mysqli_connect($host,$user,$password,$database);

$id_pembelian = $_GET['id'];
//  echo $id_pembelian;
?>

<?php
$query=mysqli_query($conn,"SELECT * FROM tb_order
		INNER JOIN tb_restoran ON tb_order.id_restoran=tb_restoran.id_restoran
		INNER JOIN tb_food ON tb_order.id_food=tb_food.id_food
		WHERE id_order='".$id_order."'
		ORDER BY tb_order.id_order DESC");
$nm_order= mysqli_fetch_array($query);
$service = mysqli_fetch_array($query);
// print($nm_pelanggan['nama']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PRINT BUKTI PEMESANAN</title>
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
  font-family: 'algerian';
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

      <h1 font-family='algerian'>UNPAM FOOD</h1>
        <div><i>KAMU LAPAR? KAMI SOLUSINYA</i></div>
        <br>
        <div>RUKO BOULVARD BLOK D57 CITRA RAYA <br>
            PANONGAN, BANTEN, TANGERANG 15710
            </div>
        <div>0895331673780/0831882736490</div>
      </div>
      <br>
      <div id="company"><h2>DATA PEMESANAN MAKANAN</h2><div><span><b>HARI/TANGGAL  :<b></span> <?php date_default_timezone_set("Asia/Jakarta"); echo $date = date('Y-m-d |  H:i:s'); ?> </div>
</div>
        <div><span><b>NAMA PELANGGAN:<b></span> <?php echo $nm_order['nama_lengkap'] ?></div>
        <div><span>NAMA RESTORAN:</span> <?php echo $nm_order['id_restoran'] ?></div>


      <hr>


    </header>
    <main>
    <h4> NOMOR ANTRIAN: <?php echo $nm_order['id_order'] ?></h4>
    <br>
      <table>
        <thead>
          <tr>
						<th>MAKANAN</th>
						<th>HARGA</th>
            <th>ALAMAT PEMESANAN</th>
            <th>NO HP</th>
            <th>EMAIL</th>
          </tr>
        </thead>
        <?php

$sql=mysqli_query($conn,"select 213_sparepart.sparepart, 213_pembelian_detail.qty, 213_pembelian_detail.diskon, 213_sparepart.harga from 213_pembelian_detail
		INNER JOIN 213_sparepart ON 213_pembelian_detail.id_sparepart=213_sparepart.id_sparepart
		INNER JOIN 213_pembelian ON 213_pembelian_detail.id_pembelian=213_pembelian.id_pembelian
		WHERE 213_pembelian_detail.id_pembelian='".$id_pembelian."'");

while($data=mysql_fetch_array($sql)){
?>
<tbody>
<tr>
<td class='unit'><?php echo $data['sparepart']?></td>
<td class='qty'><?php echo $data['qty']?></td>
<td class='desc'><?php echo "Rp." . number_format($data['harga'])?></td>
<td class='desc'><?php echo ($data['diskon']). "%"?></td>
<td>
<?php
    $ds= $data['diskon'];
	$hs= $data['harga'];
	$qt= $data['qty'];
	$harga_jasa=$data['harga_jasa'];
	$tot_diskon = ($hs * $qt)*($ds/100);
	$tot=($hs*$qt) - $tot_diskon;
	echo "Rp." . number_format("$tot");


			?>
</td>
</tr></tbody>';
<?php
}
?>
<tfoot>
    <tr>
      <td colspan=4>Harga Jasa</td>
      <td><?php echo "Rp." . number_format($nm_pelanggan['harga_jasa']) ?></td>
    </tr>
    <tr>
      <td colspan=4>Total Bayar</td>
      <td><?php echo "Rp.". number_format($nm_pelanggan['harga_jasa']+$total['total_harga']) ?></td>
    </tr>
  </tfoot>
</table>
        <!-- <tbody>
          <tr>
            <td class="service"></td>
            <td class="desc">-</td>
            <td class="unit">-</td>
            <td class="qty">-</td>
            <td class="total">-</td>
            <td class="total">-</td>
            <td class="total">-</td>
          </tr>
          <tr>
            <td colspan="6" class="grand total">TOTAL BIAYA</td>
            <td class="grand total">-</td>
          </tr>
        </tbody> -->
      </table>
      <div id="notices">
        <div class="notice">Created By</div>
        <div class="notice">IWAN SANTOSA</div>
        <div class="notice"><b>Chief Store DIMAS MOTOR</b></div>
      </div>
    </main>
  </body>
</html>

<!--CONTOH Code END-->

<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
?>