<?php
require 'dbconfig\config.php';

@$film_id="";
@$title="";
@$description="";
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
        <center><h2>Film Text (Select / Insert / Update/ Delete)</h2></center>

        <div class="inner_container">

            <form action="film_text.php" method="post">

                <label><b>Film ID</b> </label><button id="btn_go" name="fetch_btn" type="submit">Go</button>
                <input type="number" placeholder="Enter Film ID" name="film_id" value="<?php echo $film_id;?>"><br>

                <label><b>Film Title (insert or search or change to)</b></label><button id="btn_go" name="fetch1_btn" type="submit">Go</button>
                <input type="text" placeholder="Enter Title" name="title" value="<?php echo $title; ?>"><br>
        
                <label><b>film Description (insert or change to)</b></label>
                <input type="text" placeholder="Enter Description" name="description" value="<?php echo $description; ?>">

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
                    @$title=$_POST['title'];
                    @$description=$_POST['description'];

                    if($film_id=="" || $title=="" || $description=="")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        $query = "insert into film_text values ('$film_id','$title','$description')";
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
                    @$title=$_POST['title'];
                    @$description=$_POST['description'];
						
                    if($film_id != ""){
                        $query = "select * from film_text where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($title == ""){
                                $title=$row['title'];
                            }
                            if($description == "" && $query_run){
                                $description=$row['description'];
                            }
                        }
                        
                        $query = "update film_text SET title = '$title', description='$description' WHERE film_id=$film_id";
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
						echo '<script type="text/javascript">alert("Enter an Film ID to delete product")</script>';
					}
				else{
						$film_id = $_POST['film_id'];
						$query = "delete from film_text 
							WHERE film_id=$film_id";
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
                        $query = "select * from film_text where film_id=$film_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["title"] . '</td><td>' . $row["description"] . '</td></tr>';
                                //@$film_id=$row['film_id'];
                                //@$title=$row['title'];
                                //@$description=$row['description'];
							}
							else{
								echo '<script type="text/javascript">alert("Invalid film ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }
                else if(isset($_POST['fetch1_btn'])){

                    $title = $_POST['title'];

                    if($title==""){
                        echo '<script type="text/javascript">alert("Enter title to get data")</script>';
                    }
                    else{
                        $query = "select * from film_text where title='$title'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Film ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["film_id"] . '</td><td>' . $row["title"] . '</td><td>' . $row["description"] . '</td></tr>';
                                //@$film_id=$row['film_id'];
                                //@$title=$row['title'];
                                //@$description=$row['description'];
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Title Name")</script>';
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
  
  switch ($name) {
	  
  case "0":
	break;
  case "actor":
    header("Location: actor.php");
    break;
  case "address":
    header("Location: address.php");
    break;
  case "category":
    header("Location: category.php");
    break;
  case "city":
    header("Location: city.php");
    break;	
  case "country":
    header("Location: country.php");
    break;
  case "customer":
    header("Location: customer.php");
    break;
  case "district":
    header("Location: district.php");
    break;
  case "film":
    header("Location: film.php");
    break;
  case "film_actor":
    header("Location: film_actor.php");
    break;
  case "film_category":
    header("Location: film_category.php");
    break;
  case "film_rental":
    header("Location: film_rental.php");
    break;
  case "film_special_features":
    header("Location: film_special_features.php");
    break;	
  case "inventory":
    header("Location: inventory.php");
    break;
  case "language":
    header("Location: language.php");
    break;	
  case "payment":
    header("Location: payment.php");
    break;
  case "rental":
    header("Location: rental.php");
    break;
  case "staff":
    header("Location: staff.php");
    break;
  case "staff_login":
    header("Location: staff_login.php");
    break;
  case "store":
    header("Location: store.php");
    break;
  default:
    echo "<p align=center style=color:red>Invalid table name!</p>";
	break;
   }
}
?>

</body>
</html>