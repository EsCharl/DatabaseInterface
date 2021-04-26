<?php
require 'dbconfig/config.php';

@$actor_id="";
@$first_name="";
@$last_name="";
@$loops = 0;
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
        <center><h2>Actor (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="actor.php" method="post">

                <label><b>Actor ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Actor ID" name="actor_id" value="<?php echo $actor_id;?>"><br>

                <label><b>Actor First Name (insert or search or change to)</b></label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter First Name" name="first_name" value="<?php echo $first_name; ?>"><br>
        
                <label><b>Actor Last Name (insert or search or change to)</b></label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Last Name" name="last_name" value="<?php echo $last_name; ?>">

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
		</center>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$actor_id=$_POST['actor_id'];
                    @$first_name=$_POST['first_name'];
                    @$last_name=$_POST['last_name'];

                    if($actor_id=="" || $first_name=="" || $last_name=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into actor values ('$actor_id','$first_name','$last_name','$currentTime')";
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
					@$actor_id=$_POST['actor_id'];
                    @$first_name=$_POST['first_name'];
                    @$last_name=$_POST['last_name'];
						
                    if($actor_id != ""){
                        $query = "select * from actor where actor_id=$actor_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($first_name == ""){
                                $first_name=$row['first_name'];
                            }
                            if($last_name == "" && $query_run){
                                $last_name=$row['last_name'];
                            }
                        }
                        
                        $query = "update actor SET first_name = '$first_name', last_name='$last_name', last_update='$currentTime' WHERE actor_id=$actor_id";
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
                        echo '<script type="text/javascript">alert("Please input an Actor ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['actor_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Actor ID to delete product")</script>';
					}
				else{
						$actor_id = $_POST['actor_id'];
						$query = "delete from actor 
							WHERE actor_id=$actor_id";
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

                    $actor_id = $_POST['actor_id'];

                    if($actor_id==""){
                        echo '<script type="text/javascript">alert("Enter Actor_ID to get data")</script>';
                    }
                    else{
                        $query = "select * from actor where actor_id=$actor_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Actor ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while(mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["actor_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Actor ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch1_btn'])){

                    $first_name = $_POST['first_name'];

                    if($first_name==""){
                        echo '<script type="text/javascript">alert("Enter Actor First Name to get data")</script>';
                    }
                    else{
                        $query = "select * from actor where first_name='$first_name'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Actor ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while(mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["actor_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Actor First Name")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch2_btn'])){

                    $last_name = $_POST['last_name'];

                    if($last_name==""){
                        echo '<script type="text/javascript">alert("Enter Actor Last Name to get data")</script>';
                    }
                    else{
                        $query = "select * from actor where last_name='$last_name'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Actor ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while(mysqli_num_rows($query_run) != $loops){
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["actor_id"] . '</td><td>' . $row["first_name"] . '</td><td>' . $row["last_name"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Actor Last Name")</script>';
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
	  
	  if ($_POST['table'] == "") $redirect_name = "actor";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
  
}
?>

</body>
</html>