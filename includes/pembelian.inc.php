<?php
class Pembelian{
  
  private $conn;
  private $table_name = "213_pembelian";
  private $table_name_detail = "213_pembelian_detail";
  
  public $id;
  public $id_mekanik;
  public $id_sparepart;
  public $id_pelanggan;
  public $qty;
  public $harga_jasa;
  public $tgl_beli;
  public $id_pembelian;

  
  public function __construct($db){
    $this->conn = $db;
  }
  
  
 function insert(){
        $query = "insert into ".$this->table_name." values('',?,?,'0','0',?,?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id_mekanik);
		$stmt->bindParam(2, $this->id_pelanggan);
		$stmt->bindParam(3, $this->harga_jasa);
		$stmt->bindParam(4, $this->tgl_beli);
		
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
}
	
function readAll(){

		$query = "SELECT * FROM 213_pembelian 
		JOIN 213_mekanik ON 213_pembelian.id_mekanik=213_mekanik.id_mekanik
		JOIN 213_pelanggan ON 213_pembelian.id_pelanggan=213_pelanggan.id_pelanggan ORDER BY 213_pembelian.id_pembelian DESC ";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		return $stmt;
	}

function readAllItem(){

		$query = "select 213_sparepart.sparepart, 213_pembelian_detail.qty,213_pembelian_detail.diskon, 213_sparepart.harga from 213_pembelian_detail 
		INNER JOIN 213_sparepart ON 213_pembelian_detail.id_sparepart=213_sparepart.id_sparepart
		INNER JOIN 213_pembelian ON 213_pembelian_detail.id_pembelian=213_pembelian.id_pembelian
		WHERE 213_pembelian_detail.id_pembelian= :id_pembelian ";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam('id_pembelian', $this->id_pembelian);
		$stmt->execute();
		
		return $stmt;
}

function countHargaTotal(){

	$query = "select SUM((213_pembelian_detail.qty*213_sparepart.harga)-
	(213_pembelian_detail.qty*213_sparepart.harga)*(213_pembelian_detail.diskon/100)) AS total_harga from 213_pembelian_detail 
	INNER JOIN 213_sparepart ON 213_pembelian_detail.id_sparepart=213_sparepart.id_sparepart
	INNER JOIN 213_pembelian ON 213_pembelian_detail.id_pembelian=213_pembelian.id_pembelian
	WHERE 213_pembelian_detail.id_pembelian= :id_pembelian";
	$stmt = $this->conn->prepare( $query );
	$stmt->bindParam('id_pembelian', $this->id_pembelian);
	$stmt->execute();
	
	return $stmt;
}

	function readmen(){

		$query = "SELECT 213_pembelian.id_mekanik, count(*) from 213_pembelian inner join 213_mekanik on 213_pembelian.id_mekanik = 213_mekanik.id_mekanik group by 213_pembelian.id_mekanik";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		return $stmt;
	}
	
	// used when filling up the update product form
	function readOne(){
		
		 $query = "SELECT * FROM 212_kader,212_angkatan_lk WHERE 212_kader.id_angkatan_lk=212_angkatan_lk.id_angkatan_lk ORDER BY id_kader ASC";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->id = $row['id_mekanik'];
		$this->nama_mekanik = $row['nama_mekanik'];

	}
	
	// update the product
	function update(){

		$query = "UPDATE 
					" . $this->table_name . " 
				SET 
					nama_mekanik = :nama_mekanik 

				WHERE
					id_mekanik = :id";

		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':nama_mekanik', $this->nama_mekanik);
		$stmt->bindParam(':id', $this->id);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the product
	function delete(){
	
		$query = "DELETE FROM " . $this->table_name . " WHERE id_pembelian = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function deleteItem(){
	
		$query = "DELETE FROM " . $this->table_name_detail. " WHERE id_pembelian = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function countAll(){

		$query = "SELECT * FROM 213_pembelian JOIN 213_mekanik ON 213_pembelian.id_mekanik=213_mekanik.id_mekanik JOIN 213_sparepart ON 213_pembelian.id_sparepart=213_sparepart.id_sparepart";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	function hapusell($ax){
	
		$query = "DELETE FROM " . $this->table_name . " WHERE id_pembelian in $ax";
		
		$stmt = $this->conn->prepare($query);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function hapusellItem($ax){
	
		$query = "DELETE FROM " . $this->table_name_detail . " WHERE id_pembelian in $ax";
		
		$stmt = $this->conn->prepare($query);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
}
?>