
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: mainmenu.php");
    exit;
}
 
// Include config file
require_once "x1config.php";
 

?>
<html>
	<head>
		<title>Add Item</title>
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
<body style="color:white;background:black;">
<div class="container">
  <div class="box">
		<?php
			
			//if the user clicks the save button
			if(isset($_POST["save"]))
			{
				//get all the inputted values
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
						//construct a query to check if the itemcode already exists in the database
					$query = "SELECT * FROM item WHERE itemcode = '".$itemcode."'";
					
					//execute the query
					$result = mysqli_query($con, $query);
					
					//check if any rows are returned
					if(mysqli_num_rows($result) > 0)
					{
						echo "<p style='font-weight:bold;'>Itemcode already exists. Please try another itemcode.</p>";
					}
					else
					{
						//construct the insert query
						$query = "INSERT INTO item (itemcode, description, price, quantity, status) 
								  VALUES (".$itemcode.", '".$description."', ".$price.", ".$quantity.", '".$status."') ";
								  
						//call the query function to insert a record
						mysqli_query($con, $query);
						
						//display a success message
						header("location:search.php");
					}
					
				}
				else 
				{
					echo "<p>Error connecting to the database...</p>";
					
				}
				
				mysqli_close($con);
				
			}
		
		
		?>
		<form method="POST" action="create.php">
			Item Code:
			<br />
			<input type="text" name="itemcode" required />
			<br />
			<br />
			Description:
			<br />
			<input type="text" name="description" required />
			<br />
			<br />
			Price:
			<br />
			<input type="text" name="price" required />
			<br />
			<br />
			Quantity:
			<br />
			<input type="text" name="quantity" required />		
			<br />
			<br />
			Status:
			<br />
			<select name="status">
				<option value="A">Active</option>
				<option value="I">In-Active</option>
			</select>
			<br />
			<br />
			<button type="submit" name="save">Save</button>
		</form>
		  </div>
</div>
	</body>
</html>