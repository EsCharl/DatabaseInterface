<?php
require 'dbconfig/config.php';

@$customer_id="";
@$rental_id="";
@$inventory_id="";
@$staff_id="";
@$rental_date="";
@$return_date="";
@$loops = 0;
$currentTime = date("Y-m-d H:i:s", strtotime('+6 hours'));
echo $currentTime;
?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: seperate;
  margin-left: auto;
  margin-right: auto;
}
</style>
<title>Database</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
    <div id="main-wrapper">
        <center><h2>Rental (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="rental.php" method="post">

                <label><b>Rental ID</b> </label><button id="btn_go" name="fetch3_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Rental ID" name="rental_id" value="<?php echo $rental_id;?>"><br>
                
                <label><b>Rental Date (blank for current date&time (insert))</b></label><button id="btn_go" name="fetch6_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter in the format of 'YYYY-MM-DD HH:mm:ss'" name="rental_date" value="<?php echo $rental_date;?>">

                <label><b>Inventory ID (insert / change to)</b> </label><button id="btn_go" name="fetch4_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Inventory ID" name="inventory_id" value="<?php echo $inventory_id;?>"><br>

                <label><b>Customer ID (insert / delete)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Customer ID" name="customer_id" value="<?php echo $customer_id;?>"><br>

                <label><b>Return Date (blank for current D&T (ONLY update), - for NULL)</b></label><button id="btn_go" name="fetch7_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter in the format of 'YYYY-MM-DD HH:mm:ss'" name="return_date" value="<?php echo $return_date;?>"><br>

                <label><b>Staff ID (insert / change to)</b> </label><button id="btn_go" name="fetch5_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Staff ID" name="staff_id" value="<?php echo $staff_id;?>"><br>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>
			
		<center>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" align="center">
				<label for="table">Choose a table from the list:</label>
				<input list="tables" name="table" id="table">
				<datalist id="tables">
					<option value="actor">
					<option value="address">
					<option value="category">
					<option value="city">
					<option value="country">
					<option value="customer">
					<option value="district">
					<option value="film">
					<option value="film_actor">
					<option value="film_category">
					<option value="film_rental">
					<option value="film_special_features">
					<option value="film_text">
					<option value="inventory">
					<option value="language">
					<option value="payment">
					<option value="staff">
					<option value="staff_login">
					<option value="store">
				</datalist>
				<input type="submit">
			</form>
		</center>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$customer_id=$_POST['customer_id'];
                    @$rental_id=$_POST['rental_id'];
                    @$staff_id=$_POST['staff_id'];
                    @$rental_date=$_POST['rental_date'];
                    @$inventory_id=$_POST['inventory_id'];
                    @$return_date=$_POST['return_date'];

                    if($customer_id=="" || $inventory_id=="" || $staff_id==""  || $rental_id == "" || $return_date == "")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        if(empty($rental_date) && $return_date == "-"){
                            $query = "insert into rental values ($rental_id,'$currentTime',$inventory_id,$customer_id,NULL,$staff_id,'$currentTime')";
                        }else if ($return_date == "-"){
                            $query = "insert into rental values ($rental_id,'$rental_date',$inventory_id,$customer_id,NULL,$staff_id,'$currentTime')";
                        }else{
                            $query = "insert into rental values ($rental_id,'$rental_date',$inventory_id,$customer_id,'$return_date',$staff_id,'$currentTime')";
                        }
                        $query_run=mysqli_query($con,$query);
                        if($query_run)
                        {
                            echo '<script type="text/javascript">alert("Values inserted successfully")</script>';
                        }
                        else{
                            echo '<script type="text/javascript">alert("Values NOT inserted")</script>';
                        }
                    }
                }

                else if(isset($_POST['update_btn']))
				{
					@$customer_id=$_POST['customer_id'];
                    @$rental_id=$_POST['rental_id'];
                    @$staff_id=$_POST['staff_id'];
                    @$rental_date=$_POST['rental_date'];
                    @$inventory_id=$_POST['inventory_id'];
                    @$return_date=$_POST['return_date'];
						
                    if($rental_id != ""){
                        $query = "select * from rental where rental_id=$rental_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($inventory_id == ""){
                                $inventory_id=$row['inventory_id'];
                            }
                            if($staff_id == ""){
                                $staff_id=$row['staff_id'];
                            }
                            if($rental_date == ""){
                                $rental_date=$row['rental_date'];
                            }
                            if($customer_id == ""){
                                $customer_id=$row['customer_id'];
                            }
                            if($return_date == ""){
                                $return_date=$currentTime;
                            }
                            if($return_date == "-"){
                                $return_date = NULL;
                            }
                        }

                        if(empty($return_date)){
                            $query = "UPDATE `rental` SET `customer_id`=$customer_id,`staff_id`='$staff_id',`last_update`='$currentTime',rental_date='$rental_date',inventory_id=$inventory_id, return_date = NULL WHERE `rental_id`=$rental_id";
                        }else{
                            $query = "UPDATE `rental` SET `customer_id`=$customer_id,`staff_id`='$staff_id',`last_update`='$currentTime',rental_date='$rental_date',inventory_id=$inventory_id, return_date='$return_date' WHERE `rental_id`=$rental_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a Rental ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['rental_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter a Rental ID to delete product")</script>';
					}
				else{
						$rental_id = $_POST['rental_id'];

                        $query = "delete from rental WHERE rental_id=$rental_id";
						$query_run = mysqli_query($con,$query);
						if($query_run)
						{
							echo '<script type="text/javascript">alert("Product deleted")</script>';
						}
						else
						{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
					}
				}
            ?>

            <?php
                if(isset($_POST['fetch_btn'])){

                    $customer_id = $_POST['customer_id'];

                    if($customer_id==""){
                        echo '<script type="text/javascript">alert("Enter Customer ID to get data")</script>';
                    }
                    else{
                        $query = "select * from rental where customer_id=$customer_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Rental ID</th>
                                <th>Rental Date</th>
                                <th>Inventory ID</th>
                                <th>Customer ID</th>
                                <th>Return Date</th>
                                <th>Staff ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["rental_id"] . '</td><td>' . $row["rental_date"] .  '</td><td>' . $row["inventory_id"] . '</td><td>' . $row["customer_id"]  . '</td><td>' . $row["return_date"]. '</td><td>' . $row["staff_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Customer ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch3_btn'])){

                    $rental_id = $_POST['rental_id'];

                    if($rental_id==""){
                        echo '<script type="text/javascript">alert("Enter Rental ID to get data")</script>';
                    }
                    else{
                        if($rental_id == "0"){
                            $rental_id="NULL";
                            $query = "select * from rental where rental_id IS $rental_id";
                        }else{
                            $query = "select * from rental where rental_id=$rental_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Rental ID</th>
                                <th>Rental Date</th>
                                <th>Inventory ID</th>
                                <th>Customer ID</th>
                                <th>Return Date</th>
                                <th>Staff ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["rental_id"] . '</td><td>' . $row["rental_date"] .  '</td><td>' . $row["inventory_id"] . '</td><td>' . $row["customer_id"]  . '</td><td>' . $row["return_date"]. '</td><td>' . $row["staff_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Rental ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch5_btn'])){

                    $staff_id = $_POST['staff_id'];

                    if($staff_id==""){
                        echo '<script type="text/javascript">alert("Enter Staff ID to get data")</script>';
                    }
                    else{
                        $query = "select * from rental where staff_id=$staff_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Rental ID</th>
                                <th>Rental Date</th>
                                <th>Inventory ID</th>
                                <th>Customer ID</th>
                                <th>Return Date</th>
                                <th>Staff ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["rental_id"] . '</td><td>' . $row["rental_date"] .  '</td><td>' . $row["inventory_id"] . '</td><td>' . $row["customer_id"]  . '</td><td>' . $row["return_date"]. '</td><td>' . $row["staff_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Staff ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch4_btn'])){

                    $inventory_id = $_POST['inventory_id'];

                    if($inventory_id==""){
                        echo '<script type="text/javascript">alert("Enter Inventory ID to get data")</script>';
                    }
                    else{
                        $query = "select * from rental where inventory_id=$inventory_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Rental ID</th>
                                <th>Rental Date</th>
                                <th>Inventory ID</th>
                                <th>Customer ID</th>
                                <th>Return Date</th>
                                <th>Staff ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["rental_id"] . '</td><td>' . $row["rental_date"] .  '</td><td>' . $row["inventory_id"] . '</td><td>' . $row["customer_id"]  . '</td><td>' . $row["return_date"]. '</td><td>' . $row["staff_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Inventory ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch6_btn'])){

                    $rental_date = $_POST['rental_date'];

                    if($rental_date==""){
                        echo '<script type="text/javascript">alert("Enter Rental Date for data")</script>';
                    }
                    else{
                        $query = "select * from rental where rental_date='$rental_date'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Rental ID</th>
                                <th>Rental Date</th>
                                <th>Inventory ID</th>
                                <th>Customer ID</th>
                                <th>Return Date</th>
                                <th>Staff ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["rental_id"] . '</td><td>' . $row["rental_date"] .  '</td><td>' . $row["inventory_id"] . '</td><td>' . $row["customer_id"]  . '</td><td>' . $row["return_date"]. '</td><td>' . $row["staff_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Input")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch7_btn'])){

                    $return_date = $_POST['return_date'];

                    if($return_date==""){
                        echo '<script type="text/javascript">alert("Enter the Return Date for data")</script>';
                    }
                    else{
                        $query = "select * from rental where return_date='$return_date'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Rental ID</th>
                                <th>Rental Date</th>
                                <th>Inventory ID</th>
                                <th>Customer ID</th>
                                <th>Return Date</th>
                                <th>Staff ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["rental_id"] . '</td><td>' . $row["rental_date"] .  '</td><td>' . $row["inventory_id"] . '</td><td>' . $row["customer_id"]  . '</td><td>' . $row["return_date"]. '</td><td>' . $row["staff_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Input")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
            ?>
        </div>
    </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if(isset($_POST['table'])){
	  $name = $_POST['table'];
  } else {
	  $name = "0";
  }
  
  switch ($name) {
	  
  case "0":
	break;
  case "actor":
    header("Location: actor.php");
    break;
  case "address":
    header("Location: address.php");
    break;
  case "category":
    header("Location: category.php");
    break;
  case "city":
    header("Location: city.php");
    break;	
  case "country":
    header("Location: country.php");
    break;
  case "customer":
    header("Location: customer.php");
    break;
  case "district":
    header("Location: district.php");
    break;
  case "film":
    header("Location: film.php");
    break;
  case "film_actor":
    header("Location: film_actor.php");
    break;
  case "film_category":
    header("Location: film_category.php");
    break;
  case "film_rental":
    header("Location: film_rental.php");
    break;
  case "film_special_features":
    header("Location: film_special_features.php");
    break;	
  case "film_text":
    header("Location: film_text.php");
    break;
  case "inventory":
    header("Location: inventory.php");
    break;
  case "language":
    header("Location: language.php");
    break;	
  case "payment":
    header("Location: payment.php");
    break;
  case "staff":
    header("Location: staff.php");
    break;
  case "staff_login":
    header("Location: staff_login.php");
    break;
  case "store":
    header("Location: store.php");
    break;
  default:
    echo "<p align=center style=color:red>Invalid table name!</p>";
	break;
   }
}
?>

</body>
</html>