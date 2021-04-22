<?php
require 'dbconfig\config.php';

@$inventory_id="";
@$film_id="";
@$store_id="";
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
        <center><h2>Inventory (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="inventory.php" method="post">

                <label><b>Inventory ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Actor ID" name="inventory_id" value="<?php echo $inventory_id;?>"><br>

                <label><b>Film ID</b></label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Film ID" name="film_id" value="<?php echo $film_id; ?>"><br>

                <label><b>Store ID</b></label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Store ID" name="store_id" value="<?php echo $store_id; ?>"><br>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$inventory_id=$_POST['inventory_id'];
                    @$film_id=$_POST['film_id'];
                    @$store_id=$_POST['store_id'];

                    if($inventory_id=="" || $film_id=="" || $store_id=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into inventory values ($inventory_id,$film_id,$store_id,'$currentTime')";
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
					@$inventory_id=$_POST['inventory_id'];
                    @$film_id=$_POST['film_id'];
                    @$store_id=$_POST['store_id'];
						
                    if($inventory_id != ""){
                        $query = "select * from inventory where inventory_id=$inventory_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($film_id == ""){
                                $film_id=$row['film_id'];
                            }
                            if($store_id == ""){
                                $store_id=$row['store_id'];
                            }
                        }

                        $query = "update inventory SET film_id = $film_id, store_id = $store_id, last_update = '$currentTime' WHERE inventory_id=$inventory_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a film ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['inventory_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Inventory ID to delete product")</script>';
					}
				else{
						$inventory_id = $_POST['inventory_id'];
                        $film_id = $_POST['film_id'];
                        if ($film_id == ''){
                            $query = "delete from inventory WHERE inventory_id=$inventory_id";
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

                    $inventory_id = $_POST['inventory_id'];

                    if($inventory_id==""){
                        echo '<script type="text/javascript">alert("Enter inventory_id to get data")</script>';
                    }
                    else{
                        $query = "select * from inventory where inventory_id=$inventory_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Inventory ID</th>
                                <th>Film ID</th>
                                <th>Store ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["inventory_id"] . '</td><td>' . $row["film_id"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
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

                if(isset($_POST['fetch1_btn'])){

                    $film_id = $_POST['film_id'];

                    if($film_id==""){
                        echo '<script type="text/javascript">alert("Enter Film ID to get data")</script>';
                    }
                    else{
                        $query = "select * from inventory where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Inventory ID</th>
                                <th>Film ID</th>
                                <th>Store ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["inventory_id"] . '</td><td>' . $row["film_id"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid film ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch2_btn'])){

                    $store_id = $_POST['store_id'];

                    if($store_id==""){
                        echo '<script type="text/javascript">alert("Enter Store ID to get data")</script>';
                    }
                    else{
                        $query = "select * from inventory where store_id=$store_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Inventory ID</th>
                                <th>Film ID</th>
                                <th>Store ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["inventory_id"] . '</td><td>' . $row["film_id"] . '</td><td>' . $row["store_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid film ID")</script>';
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