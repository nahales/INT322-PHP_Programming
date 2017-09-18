<?php
	ob_start();
?>

<!doctype html>
<html>
  <head>
    <title>Project-View</title>
	<link rel="stylesheet" href="view.css" type="text/css" media="screen"/>
  </head>
<body>
  <?php include "project.lib";?>
    <div class="box">
	<?php title("View Records");?>  
     <table class="result">
		<tr>
		  <th>ID</th>
		  <th>Item Name</th>
		  <th>Description</th>
		  <th>Supplier<br/>Code</th>
		  <th>Cost</th>
		  <th>Price</th>
		  <th>Stock<br/>On Hand</th>
		  <th>Reorder<br/>Level</th>
		  <th>Back<br/>Order</th>
          <th>Delete/<br/>Restore</th>
		</tr>
    <?php
      $dbConnect = connectionDB();
      if($dbConnect){
          $result = mysqli_query($dbConnect, "SELECT * from inventory order by id");
          while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['itemName']; ?></td>
              <td><?php echo $row['description']; ?></td>
              <td><?php echo $row['supplierCode']; ?></td>
              <td class="textRight"><?php echo $row['cost']; ?></td>
              <td class="textRight"><?php echo $row['price']; ?></td>
              <td class="textRight"><?php echo $row['onHand']; ?></td>
              <td class="textRight"><?php echo $row['reorderPoint']; ?></td>
              <td class="textCenter"><?php echo $row['backOrder']; ?></td>
			  <?php if($row['deleted'] == 'n'){
                echo "<td class=\"textCenter\"><a href=\"delete.php?id={$row['id']}&del=n\">Delete</a></td>";
              }
              else{
                echo "<td class=\"textCenter\"><a href=\"delete.php?id={$row['id']}&del=y\">Restore</a></td>";
              } ?>
            </tr>
          <?php
		  }
          mysqli_free_result($result);
          mysqli_close($dbConnect);
      } 
	?>
   </table>
  </div> 
</body>
</html>