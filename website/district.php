<?php
require 'dbconfig\config.php';

@$district_id="";
@$district="";
$districtC="";
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
  border-collapse: collapse;
}
</style>
<title>Database</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
    <div id="main-wrapper">
        <center><h2>District (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="district.php" method="post">

                <label><b>District ID (insert or delete)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter District ID" name="district_id" value="<?php echo @$_POST['district_id'];?>"><br>

                <label><b>Country ID (insert or delete)</b> </label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Country ID" name="country_id" value="<?php echo @$_POST['country_id'];?>"><br>

                <label><b>District (insert or delete specific)</b></label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter District Name" name="district" value="<?php echo $district; ?>"><br>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$district_id=$_POST['district_id'];
                    @$country_id=$_POST['country_id'];
                    @$district=$_POST['district'];

                    if($district_id=="" || $district=="" || $country_id=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into district values ('$district_id','$country_id','$district','$currentTime')";
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
                    @$country_id=$_POST['country_id'];
                    @$district=$_POST['district'];
						
                    if($district_id != ""){
                        $query = "select * from district where district_id=$district_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($district == ""){
                                $district=$row['district'];
                            }
                            if($country_id == ""){
                                $country_id=$row['country_id'];
                            }
                        }
                        
                        $query = "update district SET country_id = $country_id ,district = '$district', last_update='$currentTime' WHERE district_id=$district_id";
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
                        echo '<script type="text/javascript">alert("Please input an District ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['district_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter a District ID to delete product")</script>';
					}
				else{
						$district_id = $_POST['district_id'];
                        $query = "delete from district WHERE district_id=$district_id";
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
                        echo '<script type="text/javascript">alert("Enter district_id to get data")</script>';
                    }
                    else{
                        $query = "select * from district where district_id=$district_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>District ID</th>
                                <th>Country ID</th>
                                <th>District</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["district_id"] . '</td><td>' . $row["country_id"] . '</td><td>' . $row["district"] . '</td><td>' . $row["last_update"] . '</td><td>';
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

                else if(isset($_POST['fetch1_btn'])){

                    $country_id = $_POST['country_id'];

                    if($country_id==""){
                        echo '<script type="text/javascript">alert("Enter Country ID to get data")</script>';
                    }
                    else{
                        $query = "select * from district where country_id='$country_id'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>District ID</th>
                                <th>Country ID</th>
                                <th>District</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["district_id"] . '</td><td>' . $row["country_id"] . '</td><td>' . $row["district"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Country ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch2_btn'])){

                    $district = $_POST['district'];

                    if($district==""){
                        echo '<script type="text/javascript">alert("Enter District to get data")</script>';
                    }
                    else{
                        $query = "select * from district where district='$district'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>District ID</th>
                                <th>Country ID</th>
                                <th>District</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["district_id"] . '</td><td>' . $row["country_id"] . '</td><td>' . $row["district"] . '</td><td>' . $row["last_update"] . '</td><td>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid District")</script>';
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