<?php
require 'dbconfig/config.php';

@$language_id="";
@$name="";
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
        <center><h2>Language (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="language.php" method="post">

                <label><b>Language ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Language ID" name="language_id" value="<?php echo $language_id;?>"><br>

                <label><b>Language Name (insert or change to)</b></label>
                <input type="text" placeholder="Enter Language Name" name="name" value="<?php echo $name; ?>"><br>

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
                    @$language_id=$_POST['language_id'];
                    @$name=$_POST['name'];

                    if($language_id=="" || $name=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into Language values ('$language_id','$name','$currentTime')";
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
					@$language_id=$_POST['language_id'];
                    @$name=$_POST['name'];
						
                    if($language_id != ""){
                        $query = "select * from Language where language_id=$language_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($name == ""){
                                $name=$row['name'];
                            }
                        }
                        
                        $query = "update Language SET name = '$name', last_update='$currentTime' WHERE language_id=$language_id";
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
                        echo '<script type="text/javascript">alert("Please input an Language ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['language_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Language ID to delete product")</script>';
					}
				else{
						$language_id = $_POST['language_id'];
						$query = "delete from Language 
							WHERE language_id=$language_id";
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

                    $language_id = $_POST['language_id'];

                    if($language_id==""){
                        echo '<script type="text/javascript">alert("Enter Language ID to get data")</script>';
                    }
                    else{
                        $query = "select * from Language where language_id=$language_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Language ID</th>
                                <th>Language Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["language_id"] . '</td><td>' . $row["name"] . '</td><td>' . $row["last_update"] . '</td></tr>';
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Language ID")</script>';
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