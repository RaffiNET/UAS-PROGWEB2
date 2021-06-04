<?php
class Order{
  
  private $conn;
  private $table_name = "tb_order";
  
  public $id_order; // kecuali ini
  public $jenis_restoran;
  public $makanan;
  public $harga;
  public $alamat_pemesanan;
  public $nama_lengkap;
  public $no_hp;
  public $email;


  
  public function __construct($db){
    $this->conn = $db;
  }
  
  
  // udah jalan
  function insert(){
    
    $query = "insert into ".$this->table_name." values('',?,?,?,?,?,?,?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->jenis_restoran);
    $stmt->bindParam(2, $this->makanan);
    $stmt->bindParam(3, $this->harga);
    $stmt->bindParam(4, $this->alamat_pemesanan);
    $stmt->bindParam(5, $this->nama_lengkap);
    $stmt->bindParam(6, $this->no_hp);
    $stmt->bindParam(7, $this->email);

    
    if($stmt->execute()){
      return true;
    }
	else{
      return false;
    }
  
  }

  //udah jalan
  function readAll(){

		$query = "SELECT tb_order.*, tb_restoran.nama_restoran FROM tb_order 
    JOIN tb_restoran ON tb_restoran.id_restoran=tb_order.id_restoran ORDER BY tb_order.id_order DESC ";
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    
    return $stmt;
	}
	
	function countAll(){

		$query = "SELECT * FROM ".$this->table_name;
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		return $stmt->rowCount();
	}
  
  function readOne(){
    
    $query = "SELECT * FROM ".$this->table_name." WHERE id_order=? LIMIT 0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $this->jenis_restoran = $row['id_restoran'];
    $this->makanan = $row['id_food'];
    $this->harga = $row['harga'];
    $this->alamat_pemesanan = $row['alamat_pemesanan'];
    $this->nama_lengkap = $row['nama_lengkap'];
    $this->no_hp = $row['no_hp'];
    $this->email = $row['email'];

  }
  
  // update the product
  function update(){

    $query = "UPDATE 
			" . $this->table_name . " 
        SET  
      id_restoran = :id_restoran,
		  id_food	 = :id_food,
		  harga	 = :harga,
       alamat_pemesanan = :alamat_pemesanan,
      nama_lengkap  = :nama_lengkap,
      no_hp  = :no_hp,
        email  = :email

	
    
        WHERE
          id_order = :id";

    $stmt = $this->conn->prepare( $query );

    $stmt->bindParam(':id_restoran', $this->jenis_restoran);
	  $stmt->bindParam(':id_food', $this->makanan);
	  $stmt->bindParam(':harga', $this->harga);
    $stmt->bindParam(':alamat_pemesanan', $this->alamat_pemesanan);
    $stmt->bindParam('nama_lengkap', $this->nama_lengkap);
    $stmt->bindParam(':no_hp', $this->no_hp);
    $stmt->bindParam(':email', $this->email);
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
  
    $query = "DELETE FROM " . $this->table_name . " WHERE id_order = ?";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);

    if($result = $stmt->execute()){
      return true;
    }else{
      return false;
    }
  }

  function hapusell($ax){
  
    $query = "DELETE FROM " . $this->table_name . " WHERE id_order in $ax";
    
    $stmt = $this->conn->prepare($query);

    if($result = $stmt->execute()){
      return true;
    }else{
      return false;
    }
  }
}
?>