<?php
require 'dbconfig/config.php';

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

	<title>Database</title>
	
	<!-- Webpage Style -->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link rel="stylesheet" href="css/style_mobile.css">
	
	<!-- Metadata -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>
<body style="background-color:#bdc3c7">
	
        <div class="row"><div class="col-12"><h2>Staff (Select / Insert / Update/ Delete)</h2></div></div>

        <div class="inner_container">

            <form action="staff.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-2">
						<label>Staff ID (Insert / delete) </label>
					</div>
					<div class="col-8">
						<input type="number" placeholder="Enter Staff ID" name="staff_id" value="<?php echo $staff_id;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>First Name (Insert / Update) </label>
					</div>
					<div class="col-8">
						<input type="text" placeholder="Enter First Name" name="first_name" value="<?php echo $first_name;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch1_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Last Name (Insert / Update) </label>
					</div>
					<div class="col-8">
						<input type="text" placeholder="Enter Last Name" name="last_name" value="<?php echo $last_name;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch2_btn" type="submit">Select</button>
					</div>
				</div>
                
				<div class="row">
					<div class="col-2">
						<label>Address ID (Insert / Update) (0 for NULL) </label>
					</div>
					<div class="col-8">
						<input type="number" placeholder="Enter Address ID" name="address_id" value="<?php echo $address_id;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch3_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Picture</label><br>
					</div>
					<div class="col-8">
						<input type="file" name="picture" value=""/><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch4_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Email Address (Insert / Update)</label>
					</div>
					<div class="col-8">
						<input type="text" placeholder="Enter Email Address" name="email" value="<?php echo $email;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch5_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Store ID (Insert / Update)</label>
					</div>
					<div class="col-8">
						<input type="number" placeholder="Enter Store ID" name="store_id" value="<?php echo $store_id;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch6_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Active (Insert / Update) </label>
					</div>
					<div class="col-8">
						<input type="number" placeholder="Enter 1 for Active, 0 for Deactive" name="active" value="<?php echo $active;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch7_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-12">
						<center>
							<button id="btn_insert" name="insert_btn" type="submit">Insert</button>
							<button id="btn_update" name="update_btn" type="submit">Update</button>
							<button id="btn_delete" name="delete_btn" type="submit">Delete</button>
						</center>
					</div>
				</div>
            </form>

            <div class="row">
				<div class="col-12">
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
								<option value="staff">
								<option value="staff_login">
								<option value="store">
							</datalist>
						<input type="submit">
					</form>
				</div>
            </div>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$staff_id=$_POST['staff_id'];
                    @$last_name=$_POST['last_name'];
                    @$first_name=$_POST['first_name'];
                    @$address_id=$_POST['address_id'];
					

                    @$email=$_POST['email'];
                    @$active=$_POST['active'];
                    @$store_id=$_POST['store_id'];
					
					if (is_uploaded_file($_FILES['picture']['tmp_name']))
						@$picture = addslashes(file_get_contents($_FILES['picture']['tmp_name'])); 
					else $picture = "";

                    if($staff_id=="" || $last_name=="" || $store_id=="" || $email=="" || $first_name=="" || $active == "" || $address_id == "" || $picture == "")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
					else if($active > 1 || $active < 0){
						echo '<script type="text/javascript">alert("Please input 1 or 0 in the Active field")</script>';
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
                    @$email=$_POST['email'];
                    @$active=$_POST['active'];
                    @$store_id=$_POST['store_id'];
					
					if (is_uploaded_file($_FILES['picture']['tmp_name']))
						@$picture = addslashes(file_get_contents($_FILES['picture']['tmp_name'])); 
					else $picture = "";
					
										
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
                                $picture = addslashes($row['picture']);
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
						if($active > 1 || $active < 0){
							echo '<script type="text/javascript">alert("Please input 1 or 0 in the Active field")</script>';
						}else{
							$query = "UPDATE `staff` SET `first_name`='$first_name',`last_name`='$last_name',`address_id`='$address_id', `picture`='$picture', `email`='$email',`last_update`='$currentTime',active=$active,store_id=$store_id WHERE `staff_id`=$staff_id";
							$query_run = mysqli_query($con,$query);
							if($query_run){
								echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
							}
							else{
								echo '<script type="text/javascript">alert("Update Error Detected")</script>';
								echo("Update Error description: " . $con -> error);
							}
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
							echo("Update Error description: " . $con -> error);
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
								
									if(!empty($row['picture'])){
										$image_info = getimagesizefromstring($row['picture']);
										$mime_type = $image_info['mime'];
									}
									else $mime_type = NULL;
									
									echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
									echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'" >' ;
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
							echo("Update Error description: " . $con -> error);
						}
                    }
                }

                if(isset($_POST['fetch1_btn'])){

                    $first_name = $_POST['first_name'];

                    if($first_name==""){
                        echo '<script type="text/javascript">alert("Enter First Name of the Staff to get data")</script>';
                    }
                    else{
                        $query = "select * from staff where first_name='$first_name'";
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
									
									if(!empty($row['picture'])){
										$image_info = getimagesizefromstring($row['picture']);
										$mime_type = $image_info['mime'];
									}
									else $mime_type = NULL;
									
									echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
									echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
									echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

									$loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid First Name")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
							echo("Update Error description: " . $con -> error);
						}
                    }
                }

                if(isset($_POST['fetch2_btn'])){

                    $last_name = $_POST['last_name'];

                    if($last_name==""){
                        echo '<script type="text/javascript">alert("Enter Last Name to get data")</script>';
                    }
                    else{
                        $query = "select * from staff where last_name='$last_name'";
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

                                if(!empty($row['picture'])){
									$image_info = getimagesizefromstring($row['picture']);
									$mime_type = $image_info['mime'];
								}
								else $mime_type = NULL;
									
								echo ($mime_type);
								echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
								echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
								echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

								$loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Last Name")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
							echo("Update Error description: " . $con -> error);
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

                                if(!empty($row['picture'])){
										$image_info = getimagesizefromstring($row['picture']);
										$mime_type = $image_info['mime'];
									}
									else $mime_type = NULL;
									
									echo ($mime_type);
									echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
									echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
									echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

									$loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Address ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
							echo("Update Error description: " . $con -> error);
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

                                if(!empty($row['picture'])){
										$image_info = getimagesizefromstring($row['picture']);
										$mime_type = $image_info['mime'];
									}
									else $mime_type = NULL;
									
									echo ($mime_type);
									echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
									echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
									echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

									$loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Email")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
							echo("Update Error description: " . $con -> error);
						}
                    }
                }

                if(isset($_POST['fetch6_btn'])){

                    $store_id = $_POST['store_id'];

                    if($store_id==""){
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
                                
                                if(!empty($row['picture'])){
										$image_info = getimagesizefromstring($row['picture']);
										$mime_type = $image_info['mime'];
									}
									else $mime_type = NULL;
									
									echo ($mime_type);
									echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
									echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
									echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

									$loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Store ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
							echo("Update Error description: " . $con -> error);
						}
                    }
                }

                if(isset($_POST['fetch4_btn'])){

                    $active = $_POST['active'];

                    if($active==""){
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
                                
                                if(!empty($row['picture'])){
										$image_info = getimagesizefromstring($row['picture']);
										$mime_type = $image_info['mime'];
									}
									else $mime_type = NULL;
									
									echo ($mime_type);
									echo '<tr><td>', $row["staff_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["address_id"] . '</td><td>';
									echo '<img src="data:'.$mime_type.';base64,'.base64_encode($row['picture']).'"."\">' ;
									echo '</td><td>' . $row["email"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["active"] . '</td><td>' . $row["last_update"] . '</td></tr>';

									$loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Value")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
							echo("Update Error description: " . $con -> error);
						}
                    }
                }
            ?>
        </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if(isset($_POST['table'])){
	  
	  if ($_POST['table'] == "") $redirect_name = "rental";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
}
?>
</body>
</html>
