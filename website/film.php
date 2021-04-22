<?php
require 'dbconfig\config.php';

@$film_id="";
@$release_year="";
@$language_id="";
@$length="";
@$original_language_id="";
@$rating="";
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
        <center><h2>Film (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="film.php" method="post">

                <label><b>Film ID (insert / delete)</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Film ID" name="film_id" value="<?php echo $film_id;?>"><br>

                <label><b>Film Release Year (insert / change to)</b> </label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Film Year" name="release_year" value="<?php echo $release_year;?>"><br>

                <label><b>Language ID (insert / change to)</b> </label><button id="btn_go" name="fetch2_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Language ID" name="language_id" value="<?php echo $language_id;?>"><br>
                
                <label><b>Original Language ID (insert / change to) (0 for NULL)</b> </label><button id="btn_go" name="fetch3_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Oringal Language ID" name="original_language_id" value="<?php echo $original_language_id;?>"><br>

                <label><b>Length (insert / change to)</b> </label><button id="btn_go" name="fetch4_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Movie Length" name="length" value="<?php echo $length;?>"><br>

                <label><b>Rating (insert / change to)</b> </label><button id="btn_go" name="fetch5_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Rating" name="rating" value="<?php echo $rating;?>"><br>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

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
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["release_year"] . '</td><td>' . $row["language_id"] . '</td><td>' . $row["original_language_id"] . '</td><td>' . $row["length"] . '</td><td>' . $row["rating"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
    </div>
</body>
</html>