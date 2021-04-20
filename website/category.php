<?php
require 'dbconfig\config.php';

@$category_id="";
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
  border-collapse: collapse;
}
</style>
<title>Database</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
    <div id="main-wrapper">
        <center><h2>Select / Insert / Update/ Delete</h2></center>

        <div class="inner_container">

            <form action="category.php" method="post">

                <label><b>Category ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter category ID" name="category_id" value="<?php echo @$_POST['category_id'];?>"><br>

                <label><b>Category Name</b></label>
                <input type="text" placeholder="Enter First Name" name="name" value="<?php echo $name; ?>"><br>

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$category_id=$_POST['category_id'];
                    @$name=$_POST['name'];

                    if($category_id=="" || $name=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into category values ('$category_id','$name','$currentTime')";
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
					@$category_id=$_POST['category_id'];
                    @$name=$_POST['name'];
						
                    if($category_id != ""){
                        $query = "select * from category where category_id=$category_id";
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
                        
                        $query = "update category SET name = '$name', last_update='$currentTime' WHERE category_id=$category_id";
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
                        echo '<script type="text/javascript">alert("Please input an category ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['category_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter an category ID to delete product")</script>';
					}
				else{
						$category_id = $_POST['category_id'];
						$query = "delete from category 
							WHERE category_id=$category_id";
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

                    $category_id = $_POST['category_id'];

                    if($category_id==""){
                        echo '<script type="text/javascript">alert("Enter category_id to get data")</script>';
                    }
                    else{
                        $query = "select * from category where category_id=$category_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["category_id"] . '</td><td>' . $row["name"] . '</td><td>' . $row["last_update"] . '</td><td>';
								//@$category_id=$row['category_id'];
								//@$name=$row['name'];
							}
							else{
								echo '<script type="text/javascript">alert("Invalid category ID")</script>';
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