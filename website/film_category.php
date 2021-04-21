<?php
require 'dbconfig\config.php';

@$film_id="";
@$category_id="";
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
        <center><h2>Film Category (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="film_category.php" method="post">

                <label><b>Film ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Film ID" name="film_id" value="<?php echo $film_id;?>"><br>

                <label><b>Category ID (insert or change to)</b></label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Category ID" name="category_id" value="<?php echo $category_id; ?>"><br>

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
                    @$category_id=$_POST['category_id'];

                    if($film_id=="" || $category_id=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into film_category values ($film_id,$category_id,'$currentTime')";
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
                    @$category_id=$_POST['category_id'];
						
                    if($film_id != "" && $category_id != ""){

                        $query = "update film_category SET category_id = $category_id, last_update = '$currentTime' WHERE film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a Category ID and an Film ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['film_id']=="" && $_POST['category_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Category ID or Film ID to delete product")</script>';
					}
				else{
						$film_id = $_POST['film_id'];
                        $category_id = $_POST['category_id'];
                        if($film_id == ''){
                            $query = "delete from film_category WHERE category_id = $category_id";
                        }else if ($category_id == ''){
                            $query = "delete from film_category WHERE film_id=$film_id";
                        }else if ($category_id != '' && $film_id != ''){
                            $query = "delete from film_category WHERE film_id=$film_id && category_id = $category_id";
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
                        echo '<script type="text/javascript">alert("Enter film_id to get data")</script>';
                    }
                    else{
                        $query = "select * from film_category where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Category ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["category_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
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

                    $category_id = $_POST['category_id'];

                    if($category_id==""){
                        echo '<script type="text/javascript">alert("Enter category_id to get data")</script>';
                    }
                    else{
                        $query = "select * from film_category where category_id=$category_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Category ID</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                 while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["category_id"] . '</td><td>' . $row["last_update"] . '</td><td>';
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