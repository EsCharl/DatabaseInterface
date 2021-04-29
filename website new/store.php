<?php
require 'dbconfig/config.php';

@$store_id="";
@$manager_staff_id="";
@$address_id="";
@$loops = 0;
$currentTime = date("Y-m-d H:i:s", strtotime('+8 hours'));
echo $currentTime;
?>

<!DOCTYPE html>
<html>
<head>

	<title>Database</title>
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- Webpage Style -->
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style_mobile.css">
	
	<!-- Metadata -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>
<body style="background-color:#bdc3c7">
	
        <div class="row"><div class="col-12"><h2>Store (Select / Insert / Update/ Delete)</h2></div></div>

        <div class="inner_container">

            <form action="store.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-2">
						<label>Store ID (insert / delete / select)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Store ID" name="store_id" value="<?php echo $store_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Manager ID</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Manager ID" name="manager_staff_id" value="<?php echo $manager_staff_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch1_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Address ID (0 for NULL)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Address ID" name="address_id" value="<?php echo $address_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch2_btn" type="submit">Select</button>
					</div>
				</div>

                <div class="row">
					<div class="col-12">
						<center>
							<button id="btn_insert" name="insert_btn" type="submit"><i class="fa fa-plus-square"></i> Insert</button>
							<button id="btn_update" name="update_btn" type="submit"><i class="fa fa-edit"></i> Update</button>
							<button id="btn_delete" name="delete_btn" type="submit"><i class="fa fa-trash"></i> Delete</button>
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
                                echo '<tr><td>', $row["store_id"] . '</td><td>' . $row["manager_staff_id"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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
                                echo '<tr><td>', $row["store_id"] . '</td><td>' . $row["manager_staff_id"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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
                                echo '<tr><td>', $row["store_id"] . '</td><td>' . $row["manager_staff_id"] . '</td><td>' . $row["address_id"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if(isset($_POST['table'])){
	  
	  if ($_POST['table'] == "") $redirect_name = "store";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
}
?>

</body>
</html>