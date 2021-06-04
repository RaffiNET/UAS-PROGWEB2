<?php
// include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="p_test.php" method="post">
<div class="form-group row">	
				  <div class="input-group col-md-2">
				    <td><input type="number" class="form-control" id="qty" name="banyak"  required ></td>
					<td><span class="input-group-btn">
					<button class="btn btn-success add-more" type="submit">Tambah
					</span></button></td>
					</div>
                    </form>
                    <form action='p_save_test.php' method='post'>
<?php
$banyak = $_GET['banyak'];
$counter=0;
$addCounter = $banyak-1;
$banyakForm = 1;
while($counter <= $addCounter)
{
echo '<div class="form-group row after-add-more">
<label for="qty">Banyaknya (qty)</label>
<div class="input-group col-md-4">
<td><input type="text" class="form-control" id="qty" name="qty'.$banyakForm++.'"  required ></td>


</div>';
$counter++;
}
?>
<input type="number" name="banyak" value="<?=$banyak?>" hidden>
<button class="btn btn-success" type="submit">SAVE</button>
					</form>
</body>
</html>