<?php
	ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <title>Cell Phone Finder</title>
   <link rel="stylesheet" href="assign1.css" type="text/css"/>
</head>
<body>

<?php
$product = $min_price = $max_price = "";
$productErr = $minErr = $maxErr = "";

 $dbserver = "db-mysql.zenit";
		$uid = "********";
		$pw = "********";
		$dbname = "********";
		
		$dbConnect = mysqli_connect($dbserver, $uid, $pw, $dbname)
		or die('Could not connect: ' . mysqli_error($dbConnect));
		

	$table_exist=mysqli_query($dbConnect,"select 1 from CELL_PHONES LIMIT 1;");

if($table_exist == false) {
      		$create_query = "CREATE TABLE CELL_PHONES (ID INT(11) NOT NULL AUTO_INCREMENT, MODEL VARCHAR(30), OS VARCHAR(30), VERSION VARCHAR(30), PRICE DECIMAL(10,2) NOT NULL, PRIMARY KEY(id));";
		if (mysqli_query($dbConnect, $create_query)){
			echo "Table created";
		}
		else{
			echo "Error: " . mysqli_error($dbConnect);
		}
		
$myfile = fopen("cell_phones.txt", "r") or die("Unable to open file!");

	$myfile = fopen("cell_phones.txt", "r");
	while(!feof($myfile)) {
		$data = explode(",", fgets($myfile));
        $MODEL = $data[0];
        $OS = $data[1];
        $VERSION = $data[2];
        $PRICE = $data[3];
	$insert_query = "INSERT INTO CELL_PHONES (MODEL,OS,VERSION,PRICE) VALUES ('$MODEL','$OS','$VERSION','$PRICE')";
	mysqli_query($dbConnect, $insert_query)or die(mysqli_error());
	}
	fclose($myfile);
   }
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$valid = true;
		  if (empty($_POST["product"])) {
			$productErr = " * You must choose a product!";
			$valid = false;
		  } 
		  else {
			$product = test_input($_POST["product"]);
		  }
		  
		  $pattern = "/^\s*[0-9]{1,}[.][0-9]{1,}\s*$/";
		  
		  if (empty($_POST["min_price"])) {
			$minErr = " * Please enter minimum price!";
			$valid = false;
		  } 
		  else if(!preg_match($pattern, $_POST["min_price"])){
			$maxErr = " * Minimum price must be a decimal number!";
			$valid = false;
		  }
		  else{
			$min_price = test_input($_POST["min_price"]);
		  }
		  
		  if (empty($_POST["max_price"])) {
			$maxErr = " * Please enter a valid number!";
			$valid = false;
		  }
		  else if(!preg_match($pattern, $_POST["max_price"])){
			$maxErr = " * Maximum price must be a decimal number!";
			$valid = false;
		  }		  
		  else {
			$max_price = test_input($_POST["max_price"]);
		  }

		}

		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
?>

	<div class="container">
		<form method="post" id='cell_phones_form' name="cell_phones_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<header>
			<h2>Cell Phone Finder</h2>
			</header><br/>
			<h3>Please provide the following information:</h3>	
				<div class="subDiv" id="Information">			
				<div class="required"><br/>
					<label for="product">Products:</label>			
					<select name="product">
							<option value=""></option>
							<option <?php if (isset($product) && $product=="Apple") echo "selected";?> value="Apple">Apple</option>
							<option <?php if (isset($product) && $product=="Samsung") echo "selected";?> value="Samsung">Samsung</option>
							<option <?php if (isset($product) && $product=="Microsoft") echo "selected";?> value="Microsoft">Microsoft</option>
							<option <?php if (isset($product) && $product=="LG") echo "selected";?> value="LG">LG</option>
							<option <?php if (isset($product) && $product=="Blackberry") echo "selected";?> value="Blackberry">Blackberry</option>
					</select><font color = "red" ><?php echo $productErr; ?></font>
				</div><br/>
				<div class="required">
					<label for="min_price">Minimum Price:</label>
					<input type="text" name="min_price" value="<?php echo $min_price;?>"/><font color = "red" ><?php echo $minErr ?></font>
					<br/><br/>
				</div>
				<div class="required">
					<label for="max_price">Maximum Price:</label>
					<input type="text" name="max_price" value="<?php echo $max_price;?>"/><font color = "red" ><?php echo $maxErr ?></font></span>
					<br/><br/>
				</div>				
				<div class="button">
					<button type="submit" name="Submit">Submit</button>&nbsp;&nbsp;
					<button type="reset"><a href="http://zenit.senecac.on.ca:16608/cgi-bin/assign1/assign1.php"></a>Reset</button><br/>
				</div><br/>
				</div>
		</form><br/>
	</div>


<?php
	if($valid){
			$select_query=mysqli_query($dbConnect,"SELRCT * FROM CELL_PHONES WHERE MODEL='$product' AND PRICE BETWEEN '$min_price' AND '$max_price' ORDER BY PRICE;");
?>
	<table border="1">
		<tr>
			<th>Model</th>	
			<th>OS</th>	
			<th>Version</th>
			<th>Price</th>
		</tr>
<?php			
	while($row = mysqli_fetch_assoc($select_query)){	
?>
		<tr>
			<td><?php print $row['MODEL'];?></td>
			<td><?php print $row['VERSION'];?></td>
			<td><?php print $row['OS'];?></td>
			<td>$<?php print $row['PRICE'];?></td>
	<?php
	}
	?>
		</tr>
	</table><br/><br/>
	<a href="http://zenit.senecac.on.ca:13634/cgi-bin/assign1/assign1.php">Search Again</a>

<?php
	mysqli_free_result($select_query);
    mysqli_close($dbConnect);
	}
	?>

<br/><br/>


</body>
</html>
