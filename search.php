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
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_start();
                header("location: mainmenu.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>

<html>
	<head>
		<title>Search Items by Description</title>
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
	
	<body style="color:white;background:black;"><div class="container" >
  <div class="box">
		<form method="GET" action="search.php">
			Type description:
			<input type="text" name="description"  />
			<button type="submit" name="search">Search</button>
			</br>
			</br>
			
			
		</form>
		
	
	<?php
	
		//if the user clicks the search button
		if(isset($_GET["search"]))
		{
			//get the value of the inputted description and remove leading and
			//trailing spaces using the trim function
			$description = trim($_GET["description"]);
			
			//establish a connection to the database market
			$con = mysqli_connect("localhost", "root", "", "market");
			
			//check if connection is successful
			if($con)
			{
				//form the query
				$sql = "SELECT * FROM item WHERE description LIKE '%".$description."%' ORDER BY description";
				
				//assign the returned or retrieved records to $items variable in PHP
				$items = mysqli_query($con, $sql);
				
				//check if there are records retrieved
				if(mysqli_num_rows($items) > 0)
				{
					//form the html table
					echo "<table border='1'  style='border: 2px solid white;'>";
					echo "	<tr>";
					echo "		<th>Item Code</th>";
					echo "		<th>Description</th>";
					echo "		<th>Price</th>";
					echo "		<th>Quantity</th>";
					echo "		<th>Status</th>";
					echo "		<th></th>";
					echo "	</tr>";
					
					//loop and visit each record in the recordset assign it to $record variable
					//and display it
					while($record = mysqli_fetch_assoc($items))
					{
						echo "<tr>";
						echo "	<td>".$record["itemcode"]."</td>";
						echo "	<td>".$record["description"]."</td>";
						echo "	<td>".$record["price"]."</td>";
						echo "	<td>".$record["quantity"]."</td>";
						echo "	<td>".$record["status"]."</td>";
						echo "	<td><a href='search.php?itemcode=".$record["itemcode"]."'>DELETE</a></td>";
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
				echo "<p>Sorry, error connecting to database...</p>";
			}
			
			mysqli_close($con);
		}
		//if the user clicks the DELETE link
	if(isset($_GET["itemcode"]))
	{
		//establish a connection to the database market
		$con = mysqli_connect("localhost", "root", "", "market");
		
		//check if connection is successful
		if($con)
		{
			//get the value of the selected itemcode
			$itemcode = $_GET["itemcode"];
			
			//form the delete query
			$sql = "DELETE FROM item WHERE itemcode = '$itemcode'";
			$result = mysqli_query($con, $sql);
			//execute the query
			if($result)
			{
				echo "<p ><b>Record deleted successfully.</b></p>"; 
				//form the query to select all records
$sql = "SELECT * FROM item";

//assign the returned or retrieved records to $items variable in PHP
$items = mysqli_query($con, $sql);

//check if there are records retrieved
if(mysqli_num_rows($items) > 0)
{
	//form the html table
	echo "<table border='1' >";
	echo "	<tr>";
	echo "		<th>Item Code</th>";
	echo "		<th>Description</th>";
	echo "		<th>Price</th>";
	echo "		<th>Quantity</th>";
	echo "		<th>Status</th>";
	echo "		<th></th>";
	echo "	</tr>";
	
	//loop and visit each record in the recordset assign it to $record variable
	//and display it
	while($record = mysqli_fetch_assoc($items))
	{
		echo "<tr>";
		echo "	<td>".$record["itemcode"]."</td>";
		echo "	<td>".$record["description"]."</td>";
		echo "	<td>".$record["price"]."</td>";
		echo "	<td>".$record["quantity"]."</td>";
		echo "	<td>".$record["status"]."</td>";
		echo "	<td><a href='search.php?itemcode=".$record["itemcode"]."'>DELETE</a></td>";
		echo "</tr>";
		
	}										
	echo "</table>";
}
else 
{
	echo "<p>No records found.</p>";
}
			}
		}
	}
	?>
	</div>
	</div>
	</body>
</html>
