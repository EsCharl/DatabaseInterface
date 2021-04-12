<?php
require 'dbconfig\config.php';

@$actor_id="";
@$first_name="";
@$last_name="";
                    $currentTime = date("Y-m-d H:i:s", strtotime('+6 hours'));
                    echo $currentTime;
?>

<!DOCTYPE html>
<html>
<head>
<title>Database</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
    <div id="main-wrapper">
        <center><h2>Select / Insert / Update/ Delete</h2></center>

        <div class="inner_container">

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
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
								@$actor_id=$row['actor_id'];
								@$first_name=$row['first_name'];
								@$last_name=$row['last_name'];
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
            ?>

            <form action="actor.php" method="post">

                <label><b>Actor ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Actor ID" name="actor_id" value="<?php echo @$_POST['actor_id'];?>"><br>

                <label><b>Actor First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="first_name" value="<?php echo $first_name; ?>"><br>
        
                <label><b>Actor Last Name</b></label>
                <input type="text" placeholder="Enter Last Name" name="last_name" value="<?php echo $last_name; ?>">

                <center>
                    <button id="btn_insert" name="insert_btn" type="submit">Insert</button>
                    <button id="btn_update" name="update_btn" type="submit">Update</button>
                    <button id="btn_delete" name="delete_btn" type="submit">Delete</button>
                </center>
            </form>

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
					if($_POST['pid']=="")
					{
						echo '<script type="text/javascript">alert("Enter an Actor ID to delete product")</script>';
					}
				else{
						$actor_id = $_POST['actor_id'];
						$query = "delete from actor 
							WHERE pid=$actor_id";
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
        </div>
    </div>
</body>
</html>