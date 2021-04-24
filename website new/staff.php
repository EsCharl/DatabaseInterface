<?php
require 'dbconfig\config.php';

@$staff_id="";
@$first_name="";
@$last_name="";
@$picture="";
@$address_id="";
@$email="";
@$store_id="";
@$active="";
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
        <center><h2>Staff (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="staff.php" method="post">

                <label><b>Staff ID (insert / delete)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Staff ID" name="staff_id" value="<?php echo $staff_id;?>"><br>

                <label><b>First Name (insert / change to)</b> </label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter First Name" name="first_name" value="<?php echo $first_name;?>"><br>

                <label><b>Last Name (insert / change to)</b> </label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Last Name" name="last_name" value="<?php echo $last_name;?>"><br>
                
                <label><b>Address ID (insert / change to) (0 for NULL)</b> </label><button id="btn_go" name="fetch3_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Address ID" name="address_id" value="<?php echo $address_id;?>"><br>

                <label><b>Picture</b></label><br>
                <input type="file" name="picture" /><br>

                <label><b>Email Address (insert / change to)</b> </label><button id="btn_go" name="fetch5_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Email Address" name="email" value="<?php echo $email;?>"><br>

                <label><b>Store ID (insert / change to)</b> </label><button id="btn_go" name="fetch6_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Store ID" name="store_id" value="<?php echo $store_id;?>"><br>

                <label><b>Active (insert / change to)</b> </label><button id="btn_go" name="fetch6_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter 1 for Active, 0 for Deactive" name="active" value="<?php echo $active;?>"><br>

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
					<option value="rental">
					<option value="staff_login">
					<option value="store">
				</datalist>
				<input type="submit">
			</form>
		</center>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$staff_id=$_POST['staff_id'];
                    @$last_name=$_POST['last_name'];
                    @$first_name=$_POST['first_name'];
                    @$address_id=$_POST['address_id'];
                    @$picture=$_POST['picture'];
                    @$email=$_POST['email'];
                    @$active=$_POST['active'];
                    @$store_id=$_POST['store_id'];

                    if($staff_id=="" || $last_name=="" || $store_id=="" || $email=="" || $first_name=="" || $active == "" || $address_id == "")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        if($address_id == "0"){
                            $address_id="NULL";
                        }
                        $query = "insert into staff values ($staff_id,'$first_name','$last_name',$address_id,'$picture','$email',$store_id,$active,'$currentTime')";
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
					@$staff_id=$_POST['staff_id'];
                    @$last_name=$_POST['last_name'];
                    @$first_name=$_POST['first_name'];
                    @$address_id=$_POST['address_id'];
                    @$picture=$_POST['picture'];
                    @$email=$_POST['email'];
                    @$active=$_POST['active'];
                    @$store_id=$_POST['store_id'];
						
                    if($staff_id != ""){
                        $query = "select * from staff where staff_id=$staff_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($last_name == ""){
                                $last_name=$row['last_name'];
                            }
                            if($first_name == ""){
                                $first_name=$row['first_name'];
                            }
                            if($address_id == ""){
                                $address_id=$row['address_id'];
                            }else if($address_id == "0"){
                                $address_id="NULL";
                            }
                            if($picture == ""){
                                $picture=$row['picture'];
                            }
                            if($email == ""){
                                $email=$row['email'];
                            }
                            if($active == ""){
                                $active=$row['active'];
                            }
                            if($store_id == ""){
                                $store_id=$row['store_id'];
                            }
                        }

                        $query = "UPDATE `staff` SET `first_name`=$first_name,`last_name`=$last_name,`address_id`=$address_id,`picture`=$picture,`email`='$email',`last_update`='$currentTime',active=$active,store_id=$store_id WHERE `staff_id`=$staff_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a Staff ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['staff_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter any of the fields to delete product")</script>';
					}
				else{
						$staff_id = $_POST['staff_id'];

                        $query = "delete from staff WHERE staff_id=$staff_id";
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

                    $staff_id = $_POST['staff_id'];

                    if($staff_id==""){
                        echo '<script type="text/javascript">alert("Enter Staff ID to get data")</script>';
                    }
                    else{
                        $query = "select * from staff where staff_id=$staff_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
								$image_info = getimagesizefromstring($row['picture']);
								$mime_type = $image_info['mime'];
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td></tr>';
								echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
								echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

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

                if(isset($_POST['fetch1_btn'])){

                    $first_name = $_POST['first_name'];

                    if($first_name==""){
                        echo '<script type="text/javascript">alert("Enter First Name of the Staff to get data")</script>';
                    }
                    else{
                        $query = "select * from staff where first_name=$first_name";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["picture"] . '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid First Name")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch2_btn'])){

                    $last_name = $_POST['last_name'];

                    if($last_name==""){
                        echo '<script type="text/javascript">alert("Enter Last Name to get data")</script>';
                    }
                    else{
                        $query = "select * from staff where last_name=$last_name";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["picture"] . '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Last Name")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch3_btn'])){

                    $address_id = $_POST['address_id'];

                    if($address_id==""){
                        echo '<script type="text/javascript">alert("Enter Address ID to get data")</script>';
                    }
                    else{
                        if($address_id == "0"){
                            $address_id="NULL";
                            $query = "select * from staff where address_id IS $address_id";
                        }else{
                            $query = "select * from staff where address_id=$address_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["picture"] . '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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

                if(isset($_POST['fetch5_btn'])){

                    $email = $_POST['email'];

                    if($email==""){
                        echo '<script type="text/javascript">alert("Enter Email to get data")</script>';
                    }
                    else{
                        $query = "select * from staff where email='$email'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["picture"] . '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Email")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch6_btn'])){

                    $store_id = $_POST['=store_id'];

                    if($address_id==""){
                        echo '<script type="text/javascript">alert("Enter Store ID to get data")</script>';
                    }
                    else{
                        if($address_id == "0"){
                            $address_id="NULL";
                            $query = "select * from staff where store_id IS $store_id";
                        }else{
                            $query = "select * from staff where store_id=$store_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["picture"] . '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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

                if(isset($_POST['fetch3_btn'])){

                    $address_id = $_POST['address_id'];

                    if($address_id==""){
                        echo '<script type="text/javascript">alert("Enter 1 or 0 to get staff that are active or non-active respectively")</script>';
                    }
                    else{
                        $query = "select * from staff where active=$active";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Staff ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address ID</th>
                                <th>Picture</th>
                                <th>Email</th>
                                <th>Store ID</th>
                                <th>Active</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["picture"] . '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Value")</script>';
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
  case "rental":
    header("Location: rental.php");
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