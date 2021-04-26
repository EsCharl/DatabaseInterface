<?php
require 'dbconfig/config.php';

@$country_id="";
@$country="";
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
	
        <div class="row"><div class="col-12"><h2>Country (Select / Insert / Update/ Delete)</h2></div></div>

        <div class="inner_container">

            <form action="country.php" method="post">

				<div class="row">
					<div class="col-2">
						<label>Country ID</label>
					</div>
					<div class="col-8">
						<input type="number" placeholder="Enter Country ID" name="country_id" value="<?php echo $country_id;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Country (insert or change to)</label>
					</div>
					<div class="col-8">
						<input type="text" placeholder="Enter Country Name" name="country" value="<?php echo $country;?>"><br>
					</div>
					<div class="col-2">
						<button id="btn_go" name="fetch1_btn" type="submit">Select</button>
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
                    @$country_id=$_POST['country_id'];
                    @$country=$_POST['country'];

                    if($country_id=="" || $country=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into country values ('$country_id','$country','$currentTime')";
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
					@$country_id=$_POST['country_id'];
                    @$country=$_POST['country'];
						
                    if($country_id != ""){
                        $query = "select * from country where country_id=$country_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($country == ""){
                                $country=$row['country'];
                            }
                        }
                        
                        $query = "update country SET country = '$country', last_update='$currentTime' WHERE country_id=$country_id";
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
                        echo '<script type="text/javascript">alert("Please input an Country ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['country_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Country ID to delete product")</script>';
					}
				else{
						$country_id = $_POST['country_id'];
						$query = "delete from country 
							WHERE country_id=$country_id";
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

                    $country_id = $_POST['country_id'];

                    if($country_id==""){
                        echo '<script type="text/javascript">alert("Enter Country ID to get data")</script>';
                    }
                    else{
                        $query = "select * from country where country_id=$country_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Country ID</th>
                                <th>Country Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["country_id"] . '</td><td>' . $row["country"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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
                else if(isset($_POST['fetch1_btn'])){

                    $country = $_POST['country'];

                    if($country==""){
                        echo '<script type="text/javascript">alert("Enter Country Name to get data")</script>';
                    }
                    else{
                        $query = "select * from country where country='$country'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Country ID</th>
                                <th>Country Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["country_id"] . '</td><td>' . $row["country"] . '</td><td>' . $row["last_update"] . '</td></tr>';
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Country Name")</script>';
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
	  
	  if ($_POST['table'] == "") $redirect_name = "country";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
}
?>

</body>
</html>