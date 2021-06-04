<?php
include_once 'header.php';
include_once 'includes/pembelian.inc.php';
$pro = new Pembelian($db);
$stmt = $pro->readmen();
$stmt2 = $pro->countAll();
?>
        <body>
		<div class="row">
		  <div class="col-xs-12 col-sm-12 col-md-2">
		  	<?php
			include_once 'sidebar.php';
			?>
		  </div>
		  <div class="col-xs-12 col-sm-12 col-md-10">
		  <ol class="breadcrumb">
			<li><a href="index.php"><span class="fa fa-home"></span> Beranda</a></li>
			
		  </ol>
		  <br/>
			
			<!--DATA LOG ADMIN-->
			<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-body">
            <div class="panel-heading">
               <center><h1> SELAMAT DATANG DI UNPAM FOOD</h1></center> 
            </div>
           
	</body>
</html>