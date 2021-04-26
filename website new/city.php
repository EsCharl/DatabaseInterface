<?php
require 'dbconfig/config.php';

@$district_id="";
@$city="";
@$city_id="";
@$loops=0;
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
        <center><h2>City (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="city.php" method="post">

                <label><b>City ID (insert or delete)</b> </label><button id="btn_go" name="fetch0_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter City ID" name="city_id" value="<?php echo $city_id;?>"><br>

                <label><b>District ID (insert / update)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter District ID" name="district_id" value="<?php echo $district_id;?>"><br>

                <label><b>City Name (insert / update)</b></label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter City Name" name="city" value="<?php echo $city; ?>"><br>

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
					<option value="rental">
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
                    @$district_id=$_POST['district_id'];
                    @$city_id=$_POST['city_id'];
                    @$city=$_POST['city'];

                    if($district_id=="" || $city=="" || $city_id=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into city values ('$city_id','$district_id','$city','$currentTime')";
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
					@$district_id=$_POST['district_id'];
                    @$city_id=$_POST['city_id'];
                    @$city=$_POST['city'];
						
                    if($city_id != ""){
                        $query = "select * from city where district_id=$city_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($city == ""){
                                $city=$row['city'];
                            }
                            if($district_id == ""){
                                $district_id=$row['district_id'];
                            }
                        }
                        
                        $query = "update city SET district_id=$district_id,city = '$city', last_update='$currentTime' WHERE city_id = $city_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run)
						{
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input an City ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['district_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter a City ID to delete product")</script>';
					}
				else{
						$district_id = $_POST['district_id'];
                        $query = "delete from city WHERE city_id=$city_id";
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

                    $district_id = $_POST['district_id'];

                    if($district_id==""){
                        echo '<script type="text/javascript">alert("Enter District ID to get data")</script>';
                    }
                    else{
                        $query = "select * from city where district_id=$district_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>City ID</th>
                                <th>District ID</th>
                                <th>City Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["city_id"] . '</td><td>' . $row["district_id"] . '</td><td>' . $row["city"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid District ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                else if(isset($_POST['fetch0_btn'])){

                    $city_id = $_POST['city_id'];

                    if($city_id==""){
                        echo '<script type="text/javascript">alert("Enter City ID to get data")</script>';
                    }
                    else{
                        $query = "select * from city where city_id='$city_id'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>City ID</th>
                                <th>District ID</th>
                                <th>City Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["city_id"] . '</td><td>' . $row["district_id"] . '</td><td>' . $row["city"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid City ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch2_btn'])){

                    $city = $_POST['city'];

                    if($city==""){
                        echo '<script type="text/javascript">alert("Enter City Name to get data")</script>';
                    }
                    else{
                        $query = "select * from city where city='$city'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>City ID</th>
                                <th>District ID</th>
                                <th>City Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["city_id"] . '</td><td>' . $row["district_id"] . '</td><td>' . $row["city"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid City")</script>';
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
  case "rental":
    header("Location: rental.php");
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