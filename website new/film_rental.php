<?php
require 'dbconfig/config.php';

@$film_id="";
@$rental_duration="";
@$rental_rate="";
@$replacement_cost="";
@$loops=0;
$currentTime = date("Y-m-d H:i:s", strtotime('+6 hours'));
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
    
        <div class="row"><div class="col-12"><h2>Film Rental (Select / Insert / Update/ Delete)</h2></div></div>

        <div class="inner_container">

            <form action="film_rental.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-2">
						<label>Film ID</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Film ID" name="film_id" value="<?php echo $film_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Rental Duration (insert or change to)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Rental Duration" name="rental_duration" value="<?php echo $rental_duration;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch1_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Rental Rate (insert or change to)</label>
					</div>
					<div class="col-4">
						<input type="number" step="0.01" placeholder="Enter Rental Rate" name="rental_rate" value="<?php echo $rental_rate; ?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch2_btn" type="submit">Select</button>
					</div>
				</div>
                
				<div class="row">
					<div class="col-2">
						<label>Replacement Cost (insert or change to)</label>
					</div>
					<div class="col-4">
						<input type="number" step="0.01" placeholder="Enter Replacement Cost" name="replacement_cost" value="<?php echo $replacement_cost; ?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch3_btn" type="submit">Select</button>
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
                    @$film_id=$_POST['film_id'];
                    @$rental_duration=$_POST['rental_duration'];
                    @$rental_rate=$_POST['rental_rate'];
                    @$replacement_cost=$_POST['replacement_cost'];

                    if($film_id=="" || $rental_duration=="" || $rental_rate=="" || $replacement_cost=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into film_rental values ('$film_id','$rental_duration','$rental_rate', '$replacement_cost','$currentTime')";
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
					@$film_id=$_POST['film_id'];
                    @$rental_duration=$_POST['rental_duration'];
                    @$rental_rate=$_POST['rental_rate'];
                    @$replacement_cost=$_POST['replacement_cost'];
						
                    if($film_id != ""){
                        $query = "select * from film_rental where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($rental_duration == ""){
                                $rental_duration=$row['rental_duration'];
                            }
                            if($rental_rate == ""){
                                $rental_rate=$row['rental_rate'];
                            }
                            if($replacement_cost == ""){
                                $replacement_cost=$row['replacement_cost'];
                            }
                        }
                        
                        $query = "update film_rental SET rental_duration = '$rental_duration',rental_rate = '$rental_rate' ,replacement_cost = '$replacement_cost', last_update='$currentTime' WHERE film_id=$film_id";
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
                        echo '<script type="text/javascript">alert("Please input an Film ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['film_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter a Film ID to delete product")</script>';
					}
				else{
						$film_id = $_POST['film_id'];
                        $query = "delete from film_rental WHERE film_id=$film_id";
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

                    $film_id = $_POST['film_id'];

                    if($film_id==""){
                        echo '<script type="text/javascript">alert("Enter Film ID to get data")</script>';
                    }
                    else{
                        $query = "select * from film_rental where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Rental Duration</th>
                                <th>Rental Rate</th>
                                <th>Replacement Cost</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["rental_duration"] . '</td><td>' . $row["rental_rate"] . '</td><td>'. $row["replacement_cost"] . '</td><td>'. $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Film ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                else if(isset($_POST['fetch1_btn'])){

                    $rental_duration = $_POST['rental_duration'];

                    if($rental_duration==""){
                        echo '<script type="text/javascript">alert("Enter Rental Duration to get data")</script>';
                    }
                    else{
                        $query = "select * from film_rental where rental_duration='$rental_duration'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Rental Duration</th>
                                <th>Rental Rate</th>
                                <th>Replacement Cost</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["rental_duration"] . '</td><td>' . $row["rental_rate"] . '</td><td>'. $row["replacement_cost"] . '</td><td>'. $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Rental Duration")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch2_btn'])){

                    $rental_rate = $_POST['rental_rate'];

                    if($rental_rate==""){
                        echo '<script type="text/javascript">alert("Enter Rental Rate to get data")</script>';
                    }
                    else{
                        $query = "select * from film_rental where rental_rate='$rental_rate'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Rental Duration</th>
                                <th>Rental Rate</th>
                                <th>Replacement Cost</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["rental_duration"] . '</td><td>' . $row["rental_rate"] . '</td><td>'. $row["replacement_cost"] . '</td><td>'. $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Rental Rate")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch3_btn'])){

                    $replacement_cost = $_POST['replacement_cost'];

                    if($replacement_cost==""){
                        echo '<script type="text/javascript">alert("Enter Replacement Cost to get data")</script>';
                    }
                    else{
                        $query = "select * from film_rental where replacement_cost='$replacement_cost'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Rental Duration</th>
                                <th>Rental Rate</th>
                                <th>Replacement Cost</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["rental_duration"] . '</td><td>' . $row["rental_rate"] . '</td><td>'. $row["replacement_cost"] . '</td><td>'. $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Replacement Cost")</script>';
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
	  
	  if ($_POST['table'] == "") $redirect_name = "film_rental";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
}
?>

</body>
</html>