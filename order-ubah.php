<?php
include_once 'header.php';
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

include_once 'includes/order.inc.php';
$eks = new Order($db);

$eks->id = $id;

$eks->readOne();

if($_POST){

	$eks->nama_lengkap = $_POST['nama_lengkap'];
	$eks->alamat_pemesanan = $_POST['alamat_pemesanan'];
	$eks->no_hp = $_POST['no_hp'];
	$eks->email = $_POST['email'];
	$eks->jenis_restoran = $_POST['id_restoran'];
	$eks->makanan = $_POST['nama_makanan'];
	$eks->harga = $_POST['harga'];

	
	if($eks->update()){
		echo "<script>location.href='order.php'</script>";
	} else{
?>
<script type="text/javascript">
window.onload=function(){
	showStickyErrorToast();
};
</script>
<?php
	}
}
?>
		<div class="row">

		  <div class="col-xs-12 col-sm-12 col-md-2">
			<?php
			include_once 'sidebar.php';
			?>
		  </div>
		  <div class="col-xs-12 col-sm-12 col-md-10">
		  <ol class="breadcrumb">
			  <li><a href="index.php"><span class="fa fa-home"></span> Beranda</a></li>
			  <li><a href="nilai.php"><span class="fa fa-gears"></span> Data Sparepart</a></li>
			  <li class="active"><span class="fa fa-pencil"></span> Ubah Data</li>
			</ol>
		  	<p style="margin-bottom:10px;">
		  		<strong style="font-size:18pt;"><span class="fa fa-pencil"></span> Ubah Data Sparepart</strong>
		  	</p>
		  	<div class="panel panel-default">
		<div class="panel-body">
			
			    <form method="post">
			    	
				  <div class="form-group">
				    <label for="harga">Nama Lengkap</label>
				    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $eks->nama_lengkap; ?>" required>
				  </div>
				  <div class="form-group">
				    <label for="alamat">Alamat Pemesanan</label>
				    <input type="text" class="form-control" id="alamat_pemesanan" name="alamat_pemesanan"  value="<?php echo $eks->alamat_pemesanan; ?>" required>
				  </div>
				  <div class="form-group">
				    <label for="harga">No.Tlp</label>
				    <input type="text" class="form-control" id="no_hp" name="no_hp"  value="<?php echo $eks->no_hp; ?>" required>
				  </div>
				  <div class="form-group">
				    <label for="harga">E-mail</label>
				    <input type="text" class="form-control" id="email" name="email"  value="<?php echo $eks->email; ?>" required>
				  </div>
				  <div class="form-group">
				    <label for="sparepart">Nama Restoran</label>
				     <select class="form-control" id="sel_resto" name="id_restoran">
								<option value="0">- Select -</option>
					   <?php 
					   $conn = mysqli_connect("localhost","root","","db_order_food");
					   $sql_restoran = "SELECT * FROM tb_restoran ";
					   $sql_data = mysqli_query($conn,$sql_restoran);
					   while($row = mysqli_fetch_assoc($sql_data) ){
					      $id_restoran = $row['id_restoran'];
					      $nama_restoran = $row['nama_restoran'];

					      if($id_restoran==$eks->jenis_restoran){
					      	$selected="selected";
					      }else{
					      	$selected="";
					      }
					      
					      // Option
					      echo "<option value='".$id_restoran."' $selected>".$nama_restoran."</option>";
					   }
					   ?>			
				</select>
				  </div>
				  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
				   <script type="text/javascript">
        $(document).ready(function(){

            $("#sel_resto").change(function(){
                var id_restoran = $(this).val();

                $.ajax({
                    url: 'getFoods.php',
                    type: 'post',
                    data: {restoran:id_restoran},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#sel_food").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i]['food_id'];
                            var name = response[i]['nama_makanan'];
                            var harga= response[i]['harga'];

                            $("#sel_food").val(name);
                            $("#harga").val(harga)

                     

                        }
                    }
                });
            });

        });
    </script>

				<div class="form-group">
				    <label for="stock">Paket</label>
				    <input class="form-control" id="sel_food" name="nama_makanan" value="<?php echo $eks->makanan; ?>" required>
				    </select>
				  </div>
				<div class="form-group">
				    <label for="harga">Harga</label>
				    <input type="text" class="form-control" id="harga" name="harga"  value="<?php echo $eks->harga; ?>" required>
				  </div>
				  </div>
				
				  <button type="submit" class="btn btn-warning"><span class="fa fa-edit"></span> Ubah</button>
				  <button type="button" onclick="location.href='order.php'" class="btn btn-success"><span class="fa fa-history"></span> Kembali</button>
				</form>
			  
		  </div></div></div>
		  <div class="col-xs-12 col-sm-12 col-md-2">
		  </div>
		</div>
		<?php
include_once 'footer.php';
?>