<?php
require 'dbconfig/config.php';

@$film_id="";
@$release_year="";
@$language_id="";
@$length="";
@$original_language_id="";
@$rating="";
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
    
        <div class="row"><div class="col-12"><h2>Film (Select / Insert / Update/ Delete)</h2></div></div>

        <div class="inner_container">

            <form action="film.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-2">
						<label>Film ID (insert / delete)</label>
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
						<label>Film Release Year (insert / change to)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Film Year" name="release_year" value="<?php echo $release_year;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch1_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Language ID (insert / change to)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Language ID" name="language_id" value="<?php echo $language_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch2_btn" type="submit">Select</button>
					</div>
				</div>
                
				<div class="row">
					<div class="col-2">
						<label>Original Language ID (insert / change to) (0 for NULL)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Oringal Language ID" name="original_language_id" value="<?php echo $original_language_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch3_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Length (insert / change to)</label><br>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Movie Length" name="length" value="<?php echo $length;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch4_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Rating (insert / change to)</label>
					</div>
					<div class="col-4">
						<input type="text" placeholder="Enter Rating" name="rating" value="<?php echo $rating;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch5_btn" type="submit">Select</button>
					</div>
				</div>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit"><i class="fa fa-plus-square"></i> Insert</button>
					<button id="btn_update" name="update_btn" type="submit"><i class="fa fa-edit"></i> Update</button>
					<button id="btn_delete" name="delete_btn" type="submit"><i class="fa fa-trash"></i> Delete</button>
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
                    @$language_id=$_POST['language_id'];
                    @$release_year=$_POST['release_year'];
                    @$original_language_id=$_POST['original_language_id'];
                    @$length=$_POST['length'];
                    @$rating=$_POST['rating'];

                    if($film_id=="" || $language_id=="" || $length=="" || $rating=="" || $release_year=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        if($original_language_id == "0"){
                            $original_language_id="NULL";
                        }
                        $query = "insert into film values ($film_id,$release_year,$language_id,$original_language_id,$length,'$rating','$currentTime')";
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
                    @$language_id=$_POST['language_id'];
                    @$release_year=$_POST['release_year'];
                    @$original_language_id=$_POST['original_language_id'];
                    @$length=$_POST['length'];
                    @$rating=$_POST['rating'];
						
                    if($film_id != ""){
                        $query = "select * from film where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($language_id == ""){
                                $language_id=$row['language_id'];
                            }
                            if($release_year == ""){
                                $release_year=$row['release_year'];
                            }
                            if($original_language_id == ""){
                                $original_language_id=$row['original_language_id'];
                            }else if($original_language_id == "0"){
                                $original_language_id="NULL";
                            }
                            if($length == ""){
                                $length=$row['length'];
                            }
                            if($rating == ""){
                                $rating=$row['rating'];
                            }
                        }

                        $query = "UPDATE `film` SET `release_year`=$release_year,`language_id`=$language_id,`original_language_id`=$original_language_id,`length`=$length,`rating`='$rating',`last_update`='$currentTime' WHERE `film_id`=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a Film ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['film_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter any of the fields to delete product")</script>';
					}
				else{
						$film_id = $_POST['film_id'];
                        if ($language_id == ''){
                            $query = "delete from film WHERE film_id=$film_id";
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
                        $query = "select * from film where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Release Year</th>
                                <th>Language ID</th>
                                <th>Original Language ID</th>
                                <th>Length</th>
                                <th>Rating</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Category ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch1_btn'])){

                    $release_year = $_POST['release_year'];

                    if($release_year==""){
                        echo '<script type="text/javascript">alert("Enter Release Year to get data")</script>';
                    }
                    else{
                        $query = "select * from film where release_year=$release_year";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Release Year</th>
                                <th>Language ID</th>
                                <th>Original Language ID</th>
                                <th>Length</th>
                                <th>Rating</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Category ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch2_btn'])){

                    $language_id = $_POST['language_id'];

                    if($language_id==""){
                        echo '<script type="text/javascript">alert("Enter Language ID to get data")</script>';
                    }
                    else{
                        $query = "select * from film where language_id=$language_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Release Year</th>
                                <th>Language ID</th>
                                <th>Original Language ID</th>
                                <th>Length</th>
                                <th>Rating</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Category ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch3_btn'])){

                    $original_language_id = $_POST['original_language_id'];

                    if($original_language_id==""){
                        echo '<script type="text/javascript">alert("Enter Original Language ID to get data")</script>';
                    }
                    else{
                        if($original_language_id == "0"){
                            $original_language_id="NULL";
                            $query = "select * from film where original_language_id IS $original_language_id";
                        }else{
                            $query = "select * from film where original_language_id=$original_language_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Release Year</th>
                                <th>Language ID</th>
                                <th>Original Language ID</th>
                                <th>Length</th>
                                <th>Rating</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Original Language ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch4_btn'])){

                    $length = $_POST['length'];

                    if($length==""){
                        echo '<script type="text/javascript">alert("Enter Length to get data")</script>';
                    }
                    else{
                        $query = "select * from film where length=$length";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Release Year</th>
                                <th>Language ID</th>
                                <th>Original Language ID</th>
                                <th>Length</th>
                                <th>Rating</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Movie Length")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch5_btn'])){

                    $rating = $_POST['rating'];

                    if($rating==""){
                        echo '<script type="text/javascript">alert("Enter Rating to get data")</script>';
                    }
                    else{
                        $query = "select * from film where rating='$rating'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Release Year</th>
                                <th>Language ID</th>
                                <th>Original Language ID</th>
                                <th>Length</th>
                                <th>Rating</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Category ID")</script>';
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
	  
	  if ($_POST['table'] == "") $redirect_name = "film";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
}
?>

</body>
</html>