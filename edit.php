<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: mainmenu.php");
    exit;
}
 
// Include config file
require_once "config.php";
 

?>
<?php
	$itemcode = "";
	$description = "";
	$price = "";
	$quantity = "";
	$status = "";
	//get the value of the URL parameter itemcode from list_all.php
	if(isset($_GET["itemcode"]))
	{
		$itemcode = $_GET["itemcode"];
		
		//check if you have established a connection to the database named: market
		$con = mysqli_connect("localhost", "root", "", "market");
		
		//check if the connection is successful...
		if($con)
		{
			//query the record that you want to edit
			
			//form the query string that will select all records from item table
			$sql = "select * from item where itemcode = ".$itemcode." ";
			
			//execute the sql query using the mysqli_query function
			$items = mysqli_query($con, $sql);
			//items variable is now a recordset					
			
			if(mysqli_num_rows($items) > 0)  
			{
				while($record = mysqli_fetch_assoc($items))
				{
					//transfer the recordset into local php variables
					$itemcode = $record["itemcode"];
					$description = $record["description"];
					$price = $record["price"];
					$quantity = $record["quantity"];
					$status = $record["status"];
					
				}
				
			}
			else 
			{
				echo "<p>Record not found.</p>";
				
			}
			
		}				
		else 
		{
			echo "<p>Error connecting to DB.</p>";
			
		}
		mysqli_close($con);
		
	}
	
	
	//if the user clicks the save_changes button
	if(isset($_POST["save_changes"]))
	{
		//get all the inputs
		$itemcode = $_POST["itemcode"];
		$description = $_POST["description"];
		$price = $_POST["price"];
		$quantity = $_POST["quantity"];
		$status = $_POST["status"];
		
		//check if you have established a connection to the database named: market
		$con = mysqli_connect("localhost", "root", "", "market");
		
		//check if the connection is successful...
		if($con)
		{
			//prepare the sql query for the update
			$sql = "update item 
						set description = '".$description."', 
							price = ".$price.",
							quantity = ".$quantity.",
							status = '".$status."' 
						where	
							itemcode = ".$itemcode." ";
							
			mysqli_query($con, $sql);
			//echo "<p>Record was updated successfully...</p>";
			header("Location: list_all.php?edited=$itemcode");
			exit;
			
		}				
		else 
		{
			echo "<p>Error connecting to DB.</p>";
			
		}
		mysqli_close($con);
		
	}

?>
<html>
	<head>
		<title>Edit Record</title>
	</head>
	<style>
	  	.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.box {
    border: 2px solid #007BFF;
  padding: 20px;
   border-radius: 10px;
  text-align: center;
}


	</style>
	<body style="color:white;background:black;">>
	<div class="container">
  <div class="box">
		<form method="POST" action="edit.php">
			Item Code:
			<br />
			<input type="text" name="itemcode" readOnly value="<?php echo $itemcode; ?>" />
			<br />
			<br />
			Description:
			<br />
			<input type="text" name="description" value="<?php echo $description; ?>" required />
			<br />
			<br />
			Price:
			<br />
			<input type="text" name="price" value="<?php echo $price; ?>" required />
			<br />
			<br />
			Quantity:
			<br />
			<input type="text" name="quantity" value="<?php echo $quantity; ?>" required />		
			<br />
			<br />
			Status:
			<br />
			<select name="status">
				<option value="A" <?php if($status == "A"){ echo "selected"; }  ?>>Active</option>
				<option value="I" <?php if($status == "I"){ echo "selected"; }  ?>>In-Active</option>
			</select>
			<br />
			<br />
			<button type="submit" name="save_changes">Save Changes</button>			
		</form>
				  </div>
</div>
	</body>
</html>