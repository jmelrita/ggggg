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
<html>
	<head>
		<title>
			List All Items
		</title>
	</head>
	<style>
  .edited {
	background-color:#FFC107;
  }
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
		<form method="POST" action="list_all.php">		
			<?php
				
				//declare the variable that will hold the item records
				$items;
				
				//establish a connection to the database market
				$con = mysqli_connect("localhost", "root", "", "market");
				
				if($con)
				{
					//this code block here will only execute if the user clicks the DELETE button
					if(isset($_POST["delete"]))
					{
						//error trapping: check first if there is at least 1 item checkbox
						//that has been checked / selected at least 1 item to be deleted
						if(isset($_POST["itemcodes"]))
						{
							//get the itemcodes
							$itemcodes = $_POST["itemcodes"];
							
							//loop through each itemcode that has been selected or checked							
							/*
							for($i=0; $i<count($itemcodes); $i++)
							{
								//form the sql query for the delete
								$sql = "delete from item where itemcode = ".$itemcodes[$i]." ";
								
								//execute the delete query
								mysqli_query($con, $sql);								
							}
							*/
							
							$itemcodesString = "";
							//$itemcodesString = "2, 1, 4, 5";
							for($i=0; $i<count($itemcodes); $i++)
							{								
								$itemcodesString = $itemcodesString . $itemcodes[$i];
								
								if($i < count($itemcodes) - 1)
								{
									$itemcodesString = $itemcodesString . ", ";
								}															
							}
							
							//form the sql query for the delete
							$sql = "delete from item where itemcode in (".$itemcodesString.") ";
								
							//execute the delete query
							mysqli_query($con, $sql);								
							
							//display success message
							echo "<p>Items(s) were deleted successfully...</p>";
							
						}
						else 
						{
							echo "<p>Please select at least 1 item to be deleted...</p>";
							
						}
						
						
						
					}
					
					
					
					
					
					//form the query string that will select all records from item table
					$sql = "select * from item order by description ";
					
					//execute the sql query using the mysqli_query function
					$items = mysqli_query($con, $sql);
					//items variable is now a recordset
					$edited_id = isset($_GET['edited']) ? $_GET['edited'] : null;
					//check if there are records retrieved
					if(mysqli_num_rows($items) > 0)
					{
						//form the html table
						echo "<table border='1'   style='border: 2px solid white;'>";
						echo "		<tr>";
						echo "			<th>Item Code</th>";
						echo "			<th>Description</th>";
						echo "			<th>Price</th>";
						echo "			<th>Quantity</th>";
						echo "			<th>Status</th>";
						echo "			<th><button type='submit' name='delete'>DELETE</button></th>";
						echo "			<th></th>";
						echo "		</tr>";
						
						//loop and visit each record in the recordset assign it to $record variable
						//and display it
						while($record = mysqli_fetch_assoc($items))
						{
							
								  $edited = $record['itemcode'] == $edited_id;
							echo "<tr>";
							echo "		<td " . ($edited ? " class=\"edited\"" : "") . ">".$record["itemcode"]."</td>";
							echo "		<td " . ($edited ? " class=\"edited\"" : "") . ">".$record["description"]."</td>";
							echo "		<td " . ($edited ? " class=\"edited\"" : "") . ">".$record["price"]."</td>";
							echo "		<td " . ($edited ? " class=\"edited\"" : "") . ">".$record["quantity"]."</td>";
							echo "		<td " . ($edited ? " class=\"edited\"" : "") . ">".$record["status"]."</td>";
							echo "		<td  " . ($edited ? " class=\"edited\"" : "") . "><input type='checkbox' name='itemcodes[]' value='".$record["itemcode"]."' /></td>";
							echo "		<td  " . ($edited ? " class=\"edited\"" : "") . "><a href='edit.php?itemcode=".$record["itemcode"]."'>EDIT</a></td>";
							echo "</tr>";
							
							}
							echo "</table>";
																
						
					}
					else 
					{
						echo "<p>Sorry, no records found...</p>";
						
					}
					
				}
				else 
				{
					
					echo "<p>Error connecting to database...</p>";
				}
				
				mysqli_close($con);
				
				
			
			
			?>				
		</form>
				  </div>
</div>
	</body>
</html>