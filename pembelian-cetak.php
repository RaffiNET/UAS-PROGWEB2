<?php
session_start();
if(!isset($_SESSION['nama_pengguna'])){
	echo "<script>location.href='login.php'</script>";
}
 // Define relative path from this script to mPDF
 
 $nama_dokumen='Data Service '; //Beri nama file PDF hasil.
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
$database="db_dimas";//isi nama database dengan tepat.
mysql_connect($host,$user,$password);
mysql_select_db($database);

$id_pembelian = $_GET['id'];
//  echo $id_pembelian;
?>

<?php
$query=mysql_query("SELECT * FROM 213_pembelian JOIN 213_mekanik ON 213_pembelian.id_mekanik=213_mekanik.id_mekanik 
JOIN 213_sparepart ON 213_pembelian.id_sparepart=213_sparepart.id_sparepart 
JOIN 213_pelanggan ON 213_pelanggan.id_pelanggan = 213_pembelian.id_pelanggan
where 213_pembelian.id_pembelian = $id_pembelian
ORDER BY id_pembelian ASC");
$nm_pelanggan = mysql_fetch_array($query);
$service + mysql_fetch_array($query);
// print($nm_pelanggan['nama']);
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
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

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
  border: 1px solid black;
  
}

table th {
  border: 1px solid black;
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
      <h1>DIMAS MOTOR</h1>
        <div><i>WE CARE YOUR CARS</i></div>
        <div id="company"><h2>INVOICE</h2><div><span><b>DATE  :<b></span> <?php date_default_timezone_set("Asia/Jakarta"); echo $date = date('Y-m-d |  H:i:s'); ?> </div>
</div>
        <br>
        <div>PERUMAHAN MEKAR ASRI 1 BLOK B6/14<br>
            PANONGAN, BANTEN, TANGERANG 15710
            </div>
        <div>0851212236363367/08119341510</div>
      </div>
      <br>
        <div><span><b>BILL TO  :<b></span> <?php echo $nm_pelanggan['nama'] ?></div>
        <div><span>Jenis Kendaraan  :</span> <?php echo $nm_pelanggan['jenis'] ?></div>
        <div><span>No.Pol :</span>  <?php echo $nm_pelanggan['nopol'] ?></div>
      
      <hr>


    </header>
    <main>
    <!-- <h4> Surat Perintah Kerja  dengan ( No Service:   )</h4> -->
    <br>
      <table>
        <thead>
          <tr>
            <th>SPAREPART</th>
            <th>QTY</th>
            <th>HARGA</th>
            <th>JASA</th>
            <th>TOTAL</th>
            <th>TANGGAL</th>
          </tr>
        </thead>
        <?php 
$sql=mysql_query("SELECT * FROM 213_pembelian JOIN 213_mekanik ON 213_pembelian.id_mekanik=213_mekanik.id_mekanik 
JOIN 213_sparepart ON 213_pembelian.id_sparepart=213_sparepart.id_sparepart 
JOIN 213_pelanggan ON 213_pelanggan.id_pelanggan = 213_pembelian.id_pelanggan
where 213_pembelian.id_pembelian = $id_pembelian
ORDER BY id_pembelian ASC");
while($data=mysql_fetch_assoc($sql)){
?>
<tbody>
<tr>
<td class='desc'><?php echo $data['sparepart']?></td>
<td class='unit'><?php echo $data['qty']?></td>
<td class='qty'><?php echo $data['harga']?></td>
<td class='total'><?php echo $data['harga_jasa']?></td>
<td>
<?php 
	$hs= $data['harga'];
	$qt= $data['qty'];
	$hj= $data['harga_jasa'];
	$tot = ($hs * $qt) + $hj;
	echo"$tot";

			
			?>
</td>
<td><?php echo $data['tgl_beli']?></td>
</tr></tbody>';
<?php
}
?>
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