<?php
require 'dbconfig\config.php';

@$store_id="";
@$manager_staff_id="";
@$address_id="";
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
  border-collapse: collapse;
}
</style>
<title>Database</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
    <div id="main-wrapper">
        <center><h2>Store (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="store.php" method="post">

                <label><b>Store ID (insert / delete / select)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Store ID" name="store_id" value="<?php echo $store_id;?>"><br>

                <label><b>Manager ID</b></label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Manager ID" name="manager_staff_id" value="<?php echo $manager_staff_id; ?>"><br>

                <label><b>Address ID (0 for NULL)</b></label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Address ID" name="address_id" value="<?php echo $address_id; ?>"><br>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$store_id=$_POST['store_id'];
                    @$manager_staff_id=$_POST['manager_staff_id'];
                    @$address_id=$_POST['address_id'];

                    if($store_id=="" || $manager_staff_id=="" || $address_id=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        if($address_id == "0"){
                            $address_id='NULL';
                        }
                        $query = "insert into store values ($store_id,$manager_staff_id,$address_id,'$currentTime')";
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
					@$store_id=$_POST['store_id'];
                    @$manager_staff_id=$_POST['manager_staff_id'];
                    @$address_id=$_POST['address_id'];
						
                    if($store_id != ""){
                        $query = "select * from store where store_id=$store_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($manager_staff_id == ""){
                                $manager_staff_id=$row['manager_staff_id'];
                            }
                            if($address_id == ""){
                                $address_id=$row['address_id'];
                            }
                            if($address_id == "0" || empty($address_id)){
                                $address_id='NULL';
                            }
                        }

                        $query = "update store SET manager_staff_id = $manager_staff_id, address_id = $address_id, last_update = '$currentTime' WHERE store_id=$store_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a Store ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['store_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Store ID to delete product")</script>';
					}
				else{
						$store_id = $_POST['store_id'];
                        $manager_staff_id = $_POST['manager_staff_id'];
                        if ($manager_staff_id == ''){
                            $query = "delete from store WHERE store_id=$store_id";
                        }
						
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

                    $store_id = $_POST['store_id'];

                    if($store_id==""){
                        echo '<script type="text/javascript">alert("Enter Store ID to get data")</script>';
                    }
                    else{
                        $query = "select * from store where store_id=$store_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Store ID</th>
                                <th>Manager ID</th>
                                <th>Address ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["store_id"] . '</td><td>' . $row["manager_staff_id"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Store ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch1_btn'])){

                    $manager_staff_id = $_POST['manager_staff_id'];

                    if($manager_staff_id==""){
                        echo '<script type="text/javascript">alert("Enter Manager Staff ID to get data")</script>';
                    }
                    else{
                        if($manager_staff_id == "0"){
                            $query = "select * from store where manager_staff_id IS NULL";
                        }else{
                            $query = "select * from store where manager_staff_id=$manager_staff_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Store ID</th>
                                <th>Manager ID</th>
                                <th>Address ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["store_id"] . '</td><td>' . $row["manager_staff_id"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Manager Staff ID ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch2_btn'])){

                    $address_id = $_POST['address_id'];

                    if($address_id==""){
                        echo '<script type="text/javascript">alert("Enter Address ID to get data")</script>';
                    }
                    else{
                        if($address_id =="0"){
                            $query = "select * from store where address_id IS NULL";
                        }else{
                            $query = "select * from store where address_id=$address_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Store ID</th>
                                <th>Manager ID</th>
                                <th>Address ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["store_id"] . '</td><td>' . $row["manager_staff_id"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Address ID")</script>';
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
	
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
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
    <option value="rental">
    <option value="staff">
    <option value="staff_login">
    <option value="store">
  </datalist>
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  $name = $_POST['table'];
  
  switch ($name) {
	  
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
    echo "Invalid table name!";
	break;
   }
}
?>

</body>
</html>