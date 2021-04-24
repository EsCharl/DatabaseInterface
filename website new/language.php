<?php
require 'dbconfig\config.php';

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
  border-collapse: collapse;
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
                                echo '<tr><td>', $row["language_id"] . '</td><td>' . $row["name"] . '</td><td>' . $row["last_update"] . '</td><td>';
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
	
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  $name = $_POST['table'];
  
  switch ($name) {
	  
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
  case "film_text":
    header("Location: film_text.php");
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
    echo "Invalid table name!";
	break;
   }
}
?>

</body>
</html>