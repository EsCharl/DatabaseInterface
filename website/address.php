<?php
require 'dbconfig\config.php';

@$address_id="";
@$address="";
@$city_id="";
@$phone="";
@$postal_code="";
@$address2="";
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
        <center><h2>Address (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="address.php" method="post">

                <label><b>Address ID (insert / delete)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Address ID" name="address_id" value="<?php echo $address_id;?>"><br>

                <label><b>Address (insert / change to)</b> </label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Address" name="address" value="<?php echo $address;?>"><br>

                <label><b>Address2 (insert / change to) (- for NULL)</b> </label><button id="btn_go" name="fetch5_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter address2" name="address2" value="<?php echo $address2;?>"><br>

                <label><b>City ID (insert / change to)</b> </label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter City ID" name="city_id" value="<?php echo $city_id;?>"><br>
                
                <label><b>Postal Code (insert / change to) (0 for NULL)</b> </label><button id="btn_go" name="fetch3_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Postal Code" name="postal_code" value="<?php echo $postal_code;?>"><br>

                <label><b>Phone (insert / change to) (- for NULL)</b> </label><button id="btn_go" name="fetch4_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Phone Number" name="phone" value="<?php echo $phone;?>"><br>


                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$address_id=$_POST['address_id'];
                    @$city_id=$_POST['city_id'];
                    @$address=$_POST['address'];
                    @$postal_code=$_POST['postal_code'];
                    @$phone=$_POST['phone'];
                    @$address2=$_POST['address2'];

                    if($address_id=="" || $city_id=="" || $postal_code=="" || $address=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        if($address2 == "-"){
                            $address2=NULL;
                        }
                        if($phone == "-"){
                            $phone=NULL;
                        }
                        if($postal_code == "0"){
                            $postal_code='NULL';
                        }
                        if(empty($phone) && empty($address2)){
                            $query = "insert into address values ($address_id,'$address',NULL,$city_id,$postal_code,NULL,'$currentTime')";
                        }else if(empty($phone)){
                            $query = "insert into address values ($address_id,'$address','$address2',$city_id,$postal_code,NULL,'$currentTime')";
                        }else if(empty($address2)){
                            $query = "insert into address values ($address_id,'$address',NULL,$city_id,$postal_code,'$phone','$currentTime')";
                        }else{
                            $query = "insert into address values ($address_id,'$address','$address2',$city_id,$postal_code,'$phone','$currentTime')";
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
					@$address_id=$_POST['address_id'];
                    @$city_id=$_POST['city_id'];
                    @$address=$_POST['address'];
                    @$postal_code=$_POST['postal_code'];
                    @$phone=$_POST['phone'];
                    @$address2=$_POST['address2'];
						
                    if($address_id != ""){
                        $query = "select * from address where address_id=$address_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($city_id == ""){
                                $city_id=$row['city_id'];
                            }
                            if($address == ""){
                                $address=$row['address'];
                            }
                            if($address2 == "-"){
                                $address2=NULL;
                            }else if($address2 == ""){
                                $address2=$row['address2'];
                            }else if($address2 == ""){
                                $address2=NULL;
                            }
                            if($phone == "-"){
                                $phone=NULL;
                            }else if($phone == ""){
                                $phone=$row['phone'];
                            }else if($phone == ""){
                                $phone=NULL;
                            }
                            if($postal_code == "0"){
                                $postal_code='NULL';
                            }else if($postal_code == ""){
                                $postal_code=$row['postal_code']; 
                            }
							if (empty($postal_code)){
								$postal_code='NULL';
							}	
                        }
                        if(empty($phone) && empty($address2)){
                            $query = "UPDATE `address` SET `address`='$address',`city_id`=$city_id,`postal_code`=$postal_code,`phone`=NULL,`address2`=NULL,`last_update`='$currentTime' WHERE `address_id`=$address_id";
                        }else if(empty($phone)){
                            $query = "UPDATE `address` SET `address`='$address',`city_id`=$city_id,`postal_code`=$postal_code,`phone`=NULL,`address2`='$address2',`last_update`='$currentTime' WHERE `address_id`=$address_id";
                        }else if(empty($address2)){
                            $query = "UPDATE `address` SET `address`='$address',`city_id`=$city_id,`postal_code`=$postal_code,`phone`=NULL,`address2`=NULL,`last_update`='$currentTime' WHERE `address_id`=$address_id";
                        }else{
                            $query = "UPDATE `address` SET `address`='$address',`city_id`=$city_id,`postal_code`=$postal_code,`phone`='$phone',`address2`='$address2',`last_update`='$currentTime' WHERE `address_id`=$address_id";
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
                        echo '<script type="text/javascript">alert("Please input an Address ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['address_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter any of the fields to delete product")</script>';
					}
				else{
						$address_id = $_POST['address_id'];
                        if ($city_id == ''){
                            $query = "delete from address WHERE address_id=$address_id";
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

                    $address_id = $_POST['address_id'];

                    if($address_id==""){
                        echo '<script type="text/javascript">alert("Enter Address ID to get data")</script>';
                    }
                    else{
                        $query = "select * from address where address_id=$address_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Address ID</th>
                                <th>Address</th>
                                <th>Address2</th>
                                <th>City ID</th>
                                <th>Postal Code</th>
                                <th>Phone Number</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["address_id"] . '</td><td>' . $row["address"] . '</td><td>' . $row["address2"] . '</td><td>' . $row["city_id"] . '</td><td>' . $row["postal_code"] . '</td><td>' . $row["phone"] . '</td><td>' . $row["last_update"] . '</td><td>';
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

                if(isset($_POST['fetch1_btn'])){

                    $address = $_POST['address'];

                    if($address==""){
                        echo '<script type="text/javascript">alert("Enter Address to get data")</script>';
                    }
                    else{
                        $query = "select * from address where address='$address'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Address ID</th>
                                <th>Address</th>
                                <th>Address2</th>
                                <th>City ID</th>
                                <th>Postal Code</th>
                                <th>Phone Number</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["address_id"] . '</td><td>' . $row["address"] . '</td><td>' . $row["address2"] . '</td><td>' . $row["city_id"] . '</td><td>' . $row["postal_code"] . '</td><td>' . $row["phone"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Address")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch2_btn'])){

                    $city_id = $_POST['city_id'];

                    if($city_id==""){
                        echo '<script type="text/javascript">alert("Enter City ID to get data")</script>';
                    }
                    else{
                        $query = "select * from address where city_id=$city_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Address ID</th>
                                <th>Address</th>
                                <th>Address2</th>
                                <th>City ID</th>
                                <th>Postal Code</th>
                                <th>Phone Number</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["address_id"] . '</td><td>' . $row["address"] . '</td><td>' . $row["address2"] . '</td><td>' . $row["city_id"] . '</td><td>' . $row["postal_code"] . '</td><td>' . $row["phone"] . '</td><td>' . $row["last_update"] . '</td><td>';
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

                if(isset($_POST['fetch3_btn'])){

                    $postal_code = $_POST['postal_code'];

                    if($postal_code==""){
                        echo '<script type="text/javascript">alert("Enter Postal Code to get data")</script>';
                    }
                    else{
                        if($postal_code == "0"){
                            $postal_code="NULL";
                            $query = "select * from address where postal_code IS $postal_code";
                        }else{
                            $query = "select * from address where postal_code=$postal_code";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Address ID</th>
                                <th>Address</th>
                                <th>Address2</th>
                                <th>City ID</th>
                                <th>Postal Code</th>
                                <th>Phone Number</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["address_id"] . '</td><td>' . $row["address"] . '</td><td>' . $row["address2"] . '</td><td>' . $row["city_id"] . '</td><td>' . $row["postal_code"] . '</td><td>' . $row["phone"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Postal Code")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch4_btn'])){

                    $phone = $_POST['phone'];

                    if($phone==""){
                        echo '<script type="text/javascript">alert("Enter Phone Number to get data")</script>';
                    }
                    else{
                        if($phone == "-"){
                            $query = "select * from address where phone IS NULL";
                        }else{
                            $query = "select * from address where phone='$phone'";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Address ID</th>
                                <th>Address</th>
                                <th>Address2</th>
                                <th>City ID</th>
                                <th>Postal Code</th>
                                <th>Phone Number</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["address_id"] . '</td><td>' . $row["address"] . '</td><td>' . $row["address2"] . '</td><td>' . $row["city_id"] . '</td><td>' . $row["postal_code"] . '</td><td>' . $row["phone"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Phone Number")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch5_btn'])){

                    $address2 = $_POST['address2'];

                    if($address2==""){
                        echo '<script type="text/javascript">alert("Enter Address2 to get data")</script>';
                    }
                    else{
                        if($address2 == "-"){
                            $query = "select * from address where address2 IS NULL";
                        }else{
                            $query = "select * from address where address2='$address2'";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Address ID</th>
                                <th>Address</th>
                                <th>Address2</th>
                                <th>City ID</th>
                                <th>Postal Code</th>
                                <th>Phone Number</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["address_id"] . '</td><td>' . $row["address"] . '</td><td>' . $row["address2"] . '</td><td>' . $row["city_id"] . '</td><td>' . $row["postal_code"] . '</td><td>' . $row["phone"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Address2")</script>';
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
</body>
</html>