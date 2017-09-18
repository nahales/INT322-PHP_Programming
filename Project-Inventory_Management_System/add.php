<?php
	ob_start();
?>

<!doctype html>
<html>
  <head>
    <title>Project-Add</title>
	<link rel="stylesheet" href="add.css" type="text/css" media="screen"/>
  </head>
  <body>
    <?php
     $nameErr=$descriptionErr=$codeErr=$costErr=$priceErr=$onHandErr=$reorderErr=$backOrderErr="";
     $valid = true;
	 include "project.lib";
    if($_POST){
		foreach($_POST as $key => $value){
		  $$key = cleanInput($value); 
	    }
		
		if(empty($name)){
            $nameErr = "*Name is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*[a-zA-Z\s\:\;\-\,\'\d]*\s*$/", $name)){
            $nameErr = "*Name is INVALID.";
            $valid = false;
		  }
		}
        
		if(empty($description)){
            $descriptionErr = "*Description is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*[a-zA-Z\d\.\,\'\-\s\\n]*\s*$/", $description)){
            $descriptionErr = "*Description is INVALID.";
            $valid = false;
		  }
		}
		
        if(empty($supplierCode)){
            $codeErr = "*Supplier code is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*[a-zA-Z\d\-\s]*\s*$/", $supplierCode)){
            $codeErr = "*Supplier code is INVALID.";
            $valid = false;
		  }
		}
		
        if(empty($cost)){
            $costErr = "*Cost is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*\d+\.\d{2}\s*$/", $cost)){
            $costErr = "*Cost is INVALID.";
            $valid = false;
		  }
		}
		
		if(empty($price)){
            $priceErr = "*Price is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*\d+\.\d{2}\s*$/", $price)){
            $priceErr = "*Price is INVALID.";
            $valid = false;
		  }
		}
		
		if(empty($onHand) && $onHand !== '0'){
            $onHandErr = "*On hand is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*\d+\s*$/", $onHand)){
            $onHandErr = "*On hand is INVALID.";
            $valid = false;
		  }
		}
		
		if(empty($reorderPoint) && $reorderPoint !== '0'){
            $reorderErr = "*Reorder point is required.";
            $valid = false;
        }
		else{
		  if (!preg_match("/^\s*\d+\s*$/", $reorderPoint)){
            $reorderErr = "*Reorder point is INVALID.";
            $valid = false;
		  }
		}
	}
    
	if($_POST && $valid){
		  $dbConnect = connectionDB();
		  if($dbConnect){
			 $qry = "INSERT INTO inventory (itemName, description, supplierCode, cost, price, onHand, reorderPoint, backOrder)
				  Values('$name','$description','$supplierCode','$cost','$price','$onHand','$reorderPoint','$backOrder')";
			 mysqli_query($dbConnect, $qry);
	         mysqli_close($dbConnect);
			 header("Location: view.php");
		  }
		  else{
			echo "Cannot connect to database. " . mysqli_connect_error($connect);
		  }		
		}
	
    else{
    ?>
    <div class="box">
	<?php title("Add Records");?>   
    <form method="post" action="add.php">
        <table style = "margin-left:250px";>
            <tr>
                <td>Item Name:</td>
                <td><input type="text" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"></td>
				<td><span class="error"><?php echo $nameErr;?></span></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea name="description"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea></td>
				<td><span class="error"><?php echo $descriptionErr;?></span></td>
            </tr>
             <tr>
                <td>Supplier Code:</td>
                <td><input type="text" name="supplierCode" value="<?php if (isset($_POST['supplierCode'])) echo $_POST['supplierCode']; ?>"></td>
				<td><span class="error"><?php echo $codeErr;?></span></td>
            </tr>
             <tr>
                <td>Cost:</td>
                <td><input type="text" name="cost" value="<?php if (isset($_POST['cost'])) echo $_POST['cost']; ?>"></td>
				<td><span class="error"><?php echo $costErr;?></span></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><input type="text" name="price" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>"></td>
				<td><span class="error"><?php echo $priceErr;?></span></td>
            </tr>
             <tr>
                <td>On Hand:</td>
                <td><input type="text" name="onHand" value="<?php if (isset($_POST['onHand'])) echo $_POST['onHand']; ?>"></td>
				<td><span class="error"><?php echo $onHandErr;?></span></td>
            </tr>
			  <tr>
                <td>Reorder Point:</td>
                <td><input type="text" name="reorderPoint" value="<?php if (isset($_POST['reorderPoint'])) echo $_POST['reorderPoint']; ?>"></td>
				<td><span class="error"><?php echo $reorderErr;?></span></td>
            </tr>
              <tr>
                <td>Backorder:</td>
                <td><input type="text" name="backOrder" value="<?php if (isset($_POST['backOrder'])) echo $_POST['backOrder']; ?>"></td>
				<td><span class="error"><?php echo $backOrderErr;?></span></td>
            </tr>
        </table>
		<p><input type="submit"></p>
    </form>
    </div>
    <?php
    }
    ?>
  </body>
</html>