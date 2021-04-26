<?php
require 'dbconfig/config.php';

@$film_id="";
@$special_features="";
@$special_featuresC="";
@$loops=0;
$currentTime = date("Y-m-d H:i:s", strtotime('+6 hours'));
echo $currentTime;
?>

<!DOCTYPE html>
<html>
<head>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<style>
label{
    font-family: 'Montserrat';
    font-size: 15px;
}
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
        <center><h2>Film Special Features (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="film_special_features.php" method="post">

                <label><b>Film ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Film ID" name="film_id" value="<?php echo $film_id;?>"><br>

                <label><b>Film Special Features (insert or delete specific)</b></label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Film Special Features" name="special_features" value="<?php echo $special_features; ?>"><br>

                <label><b>Film Special Features (change to)</b></label>
                <input type="text" placeholder="Enter Film Special Features that is used to change to" name="special_featuresC" value="<?php echo $special_featuresC; ?>"><br>

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
                    @$film_id=$_POST['film_id'];
                    @$special_features=$_POST['special_features'];

                    if($film_id=="" || $special_features=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in Film ID and Film Special Features")</script>';
                    }
                    else{
                        $query = "insert into film_special_features values ('$film_id','$special_features','$currentTime')";
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
                    @$special_features=$_POST['special_features'];
                    @$special_featuresC=$_POST['special_featuresC'];
						
                    if($film_id != ""){
                        $query = "select * from film_special_features where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($special_features == ""){
                                $special_features=$row['special_features'];
                            }
                            if($special_featuresC == ""){
                                $special_featuresC=$special_features;
                            }
                        }
                        
                        $query = "update film_special_features SET special_features = '$special_featuresC', last_update='$currentTime' WHERE film_id=$film_id && special_features='$special_features'";
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
					if($_POST['film_id']=="" && $_POST['special_features']=="")
					{
						echo '<script type="text/javascript">alert("Enter a Film ID or/and special_features to delete product")</script>';
					}
				else{
						$film_id = $_POST['film_id'];
                        $special_features = $_POST['special_features'];
                        if($film_id == ""){
                            $query = "delete from film_special_features WHERE special_features='$special_features'";
                        }else if($special_features == ""){
                            $query = "delete from film_special_features WHERE film_id=$film_id";
                        }else{
						    $query = "delete from film_special_features WHERE film_id=$film_id && special_features='$special_features'";
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

                    $film_id = $_POST['film_id'];

                    if($film_id==""){
                        echo '<script type="text/javascript">alert("Enter Film ID to get data")</script>';
                    }
                    else{
                        $query = "select * from film_special_features where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Film Special Feature</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["special_features"] . '</td><td>' . $row["last_update"] . '</td></tr>';
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

                    $special_features = $_POST['special_features'];

                    if($special_features==""){
                        echo '<script type="text/javascript">alert("Enter Special Features to get data")</script>';
                    }
                    else{
                        $query = "select * from film_special_features where special_features='$special_features'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Film Special Feature</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["special_features"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Special Features")</script>';
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
  
  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $name . ".php';</script>";
  echo $redirect_str;
  exit();
}
?>

</body>
</html>