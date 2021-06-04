<?php
session_start();
if (!isset($_SESSION['nama_pengguna'])) {
  echo "<script>location.href='login.php'</script>";
}
$host = "localhost";
$user = "root";
$password = "5758";
$database = "db_order_food";
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['id'])) {
  $id_order = $_GET['id'];
} else {
  die("Error. No ID Selected!");
}
require_once("dompdf/autoload.inc.php");

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$sql = "SELECT 
          tb_order.id_order, 
          tb_order.nama_lengkap,  
          tb_order.alamat_pemesanan,  
          tb_order.no_hp,  
          tb_order.harga,  
          tb_order.email, 
          tb_restoran.id_restoran, 
          tb_restoran.nama_restoran, 
          tb_food.nama_makanan , 
          tb_food.harga 
          FROM tb_order 
          JOIN tb_restoran ON tb_restoran.id_restoran = tb_order.id_restoran 
          JOIN tb_food ON tb_food.id_restoran = tb_restoran.id_restoran 
          WHERE tb_order.id_order = '$id_order'";
$result = $conn->query($sql);
date_default_timezone_set("Asia/Jakarta");
echo $date = date('Y-m-d |  H:i:s');

$html = '<center><h3>Data Pemesanan Makanan</h3></center>';
$html .= "<center>Per " . $date . "(Waktu dan Jam Sekarang)</center><hr/><br/>";
$html .= '<table border="1" width="100%">
    <tr align="center">
    <th>MAKANAN</th>
    <th>HARGA</th>
    <th>ALAMAT PEMESANAN</th>
    <th>NO HP</th>
    <th>EMAIL</th>
    </tr>';
$no = 1;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
    <td>" . $row['nama_makanan'] . "</td>
    <td>" . "Rp." . number_format($row['harga']) . "</td>
    <td>" . $row['alamat_pemesanan'] . "</td>
    <td>" . $row['no_hp'] . "</td>
    <td>" . $row['email'] . "</td>
    </tr>";
  }
}
$html .= "</html>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream('BUKTI_PEMESANAN.pdf');
