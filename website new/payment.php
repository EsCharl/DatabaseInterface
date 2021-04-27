<?php
require 'dbconfig/config.php';

@$customer_id="";
@$payment_id="";
@$first_name="";
@$last_name="";
@$picture="";
@$rental_id="";
@$staff_id="";
@$amount="";
@$payment_date="";
@$loops = 0;
$currentTime = date("Y-m-d H:i:s", strtotime('+6 hours'));
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
	
        <div class="row"><div class="col-12"><h2>Payment (Select / Insert / Update/ Delete)</h2></div></div>

        <div class="inner_container">

            <form action="payment.php" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-2">
						<label>Payment ID (insert / change to)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Payment ID" name="payment_id" value="<?php echo $payment_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch4_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Customer ID (insert / change to)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Customer ID" name="customer_id" value="<?php echo $customer_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Staff ID (insert / change to)</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Staff ID" name="staff_id" value="<?php echo $staff_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch5_btn" type="submit">Select</button>
					</div>
				</div>
                
				<div class="row">
					<div class="col-2">
						<label>Rental ID (insert / change to) (0 for NULL (Not for Update))</label>
					</div>
					<div class="col-4">
						<input type="number" placeholder="Enter Rental ID" name="rental_id" value="<?php echo $rental_id;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch3_btn" type="submit">Select</button>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<label>Amount (insert / change to)</label><br>
					</div>
					<div class="col-4">
						<input type="number" step="0.01" placeholder="Enter Amount" name="amount" value="<?php echo $amount;?>"><br>
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch6_btn" type="submit">Select</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-2">
						<label>Payment Date (blank for current date and time (insert))</label>
					</div>
					<div class="col-4">
						<input type="text" placeholder="Enter in the format of 'YYYY-MM-DD HH:mm:ss' or 'YYYY-MM-DD'" name="payment_date" value="<?php echo $payment_date;?>">
					</div>
					<div class="col-6">
						<button id="btn_go" name="fetch7_btn" type="submit">Select</button>
					</div>
				</div>

                <div class="row">
					<div class="col-12">
						<center>
							<button id="btn_insert" name="insert_btn" type="submit"><i class="fa fa-plus-square"></i> Insert</button>
							<button id="btn_update" name="update_btn" type="submit"><i class="fa fa-edit"></i> Update</button>
							<button id="btn_delete" name="delete_btn" type="submit"><i class="fa fa-trash"></i> Delete</button>
						</center>
					</div>
				</div>
            </form>

            <div class="row">
				<div class="col-12">
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
				</div>
            </div>

            <?php
                if(isset($_POST['insert_btn']))
                {
                    @$customer_id=$_POST['customer_id'];
                    @$rental_id=$_POST['rental_id'];
                    @$staff_id=$_POST['staff_id'];
                    @$amount=$_POST['amount'];
                    @$payment_id=$_POST['payment_id'];
                    @$payment_date=$_POST['payment_date'];

                    if($customer_id=="" || $payment_id=="" || $staff_id=="" || $amount == "" || $rental_id == "")
                    {
                        echo '<script type="text/javascript">alert("Insert values in all fields")</script>';
                    }
                    else{
                        if($rental_id == "0"){
                            $rental_id="NULL";
                        }
                        if(empty($payment_date)){
                            $query = "insert into payment values ($payment_id,$customer_id,$staff_id,$rental_id,$amount,'$currentTime','$currentTime')";
                        }else{
                            $query = "insert into payment values ($payment_id,$customer_id,$staff_id,$rental_id,$amount,'$payment_date','$currentTime')";
                        }
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
					@$customer_id=$_POST['customer_id'];
                    @$rental_id=$_POST['rental_id'];
                    @$staff_id=$_POST['staff_id'];
                    @$amount=$_POST['amount'];
                    @$payment_id=$_POST['payment_id'];
                    @$payment_date=$_POST['payment_date'];
						
                    if($payment_id != ""){
                        $query = "select * from payment where payment_id=$payment_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            if(mysqli_num_rows($query_run)>0)
							{
								$row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
							}
                            if($rental_id == ""){
                                $rental_id=$row['rental_id'];
                            }
                            if($staff_id == ""){
                                $staff_id=$row['staff_id'];
                            }
                            if($amount == ""){
                                $amount=$row['amount'];
                            }
                            if($customer_id == ""){
                                $customer_id=$row['customer_id'];
                            }
                            if($payment_date == ""){
                                $payment_date=$row['payment_date'];
                            }
                        }

                        $query = "UPDATE `payment` SET `rental_id`=$rental_id,`staff_id`='$staff_id',`last_update`='$currentTime',amount=$amount,payment_date='$payment_date', customer_id=$customer_id WHERE `payment_id`=$payment_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
							echo '<script type="text/javascript">alert("Product Updated successfully")</script>';
						}
						else{
							echo '<script type="text/javascript">alert("Error")</script>';
						}
                    }
                    else{
                        echo '<script type="text/javascript">alert("Please input a payment ID")</script>';
                    }
				}
				
				else if(isset($_POST['delete_btn']))
				{
					if($_POST['payment_id']=="")
					{
						echo '<script type="text/javascript">alert("Enter a Payment ID to delete product")</script>';
					}
				else{
						$payment_id = $_POST['payment_id'];

                        $query = "delete from payment WHERE payment_id=$payment_id";
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

                    $customer_id = $_POST['customer_id'];

                    if($customer_id==""){
                        echo '<script type="text/javascript">alert("Enter Customer ID to get data")</script>';
                    }
                    else{
                        $query = "select * from payment where customer_id=$customer_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Payment ID</th>
                                <th>Customer ID</th>
                                <th>Staff ID</th>
                                <th>Rental ID</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["payment_id"] . '</td><td>' . $row["customer_id"] .  '</td><td>' . $row["staff_id"] . '</td><td>' . $row["rental_id"] . '</td><td>' . $row["amount"] . '</td><td>' . $row["payment_date"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid payment ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch3_btn'])){

                    $rental_id = $_POST['rental_id'];

                    if($rental_id==""){
                        echo '<script type="text/javascript">alert("Enter Rental ID to get data")</script>';
                    }
                    else{
                        if($rental_id == "0"){
                            $rental_id="NULL";
                            $query = "select * from payment where rental_id IS $rental_id";
                        }else{
                            $query = "select * from payment where rental_id=$rental_id";
                        }
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Payment ID</th>
                                <th>Customer ID</th>
                                <th>Staff ID</th>
                                <th>Rental ID</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["payment_id"] . '</td><td>' . $row["customer_id"] .  '</td><td>' . $row["staff_id"] . '</td><td>' . $row["rental_id"] . '</td><td>' . $row["amount"] . '</td><td>' . $row["payment_date"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Rental ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch5_btn'])){

                    $staff_id = $_POST['staff_id'];

                    if($staff_id==""){
                        echo '<script type="text/javascript">alert("Enter Staff ID to get data")</script>';
                    }
                    else{
                        $query = "select * from payment where staff_id=$staff_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Payment ID</th>
                                <th>Customer ID</th>
                                <th>Staff ID</th>
                                <th>Rental ID</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["payment_id"] . '</td><td>' . $row["customer_id"] .  '</td><td>' . $row["staff_id"] . '</td><td>' . $row["rental_id"] . '</td><td>' . $row["amount"] . '</td><td>' . $row["payment_date"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Email")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch4_btn'])){

                    $payment_id = $_POST['payment_id'];

                    if($payment_id==""){
                        echo '<script type="text/javascript">alert("Enter Payment ID to get data")</script>';
                    }
                    else{
                        $query = "select * from payment where payment_id=$payment_id";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Payment ID</th>
                                <th>Customer ID</th>
                                <th>Staff ID</th>
                                <th>Rental ID</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["payment_id"] . '</td><td>' . $row["customer_id"] .  '</td><td>' . $row["staff_id"] . '</td><td>' . $row["rental_id"] . '</td><td>' . $row["amount"] . '</td><td>' . $row["payment_date"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Payment ID")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch6_btn'])){

                    $amount = $_POST['amount'];

                    if($amount==""){
                        echo '<script type="text/javascript">alert("Enter an amount")</script>';
                    }
                    else{
                        $query = "select * from payment where amount=$amount";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Payment ID</th>
                                <th>Customer ID</th>
                                <th>Staff ID</th>
                                <th>Rental ID</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["payment_id"] . '</td><td>' . $row["customer_id"] .  '</td><td>' . $row["staff_id"] . '</td><td>' . $row["rental_id"] . '</td><td>' . $row["amount"] . '</td><td>' . $row["payment_date"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Input")</script>';
							}
						}
						else{
							echo '<script type="text/javascript">alert("Error in query")</script>';
						}
                    }
                }

                if(isset($_POST['fetch7_btn'])){

                    $payment_date = $_POST['payment_date'];

                    if($payment_date==""){
                        echo '<script type="text/javascript">alert("Enter the date")</script>';
                    }
                    else{
                        $query = "select * from payment where payment_date LIKE '$payment_date%'";
                        $query_run = mysqli_query($con,$query);
                        if($query_run){
                            echo '<div class = "w3-container">
            
                                <table class="w3-table_all">
                                <tread>
                                <tr class="w3-light-grey">
                                <th>Payment ID</th>
                                <th>Customer ID</th>
                                <th>Staff ID</th>
                                <th>Rental ID</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Last Update</th>
                                </tr>
                                </tread>';
                            if(mysqli_num_rows($query_run)>0)
							{
                                while (mysqli_num_rows($query_run) != $loops){
                                $row = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
                                echo '<tr><td>', $row["payment_id"] . '</td><td>' . $row["customer_id"] .  '</td><td>' . $row["staff_id"] . '</td><td>' . $row["rental_id"] . '</td><td>' . $row["amount"] . '</td><td>' . $row["payment_date"] . '</td><td>' . $row["last_update"] . '</td></tr>';
                                $loops++;
                                }
							}
							else{
								echo '<script type="text/javascript">alert("Invalid Input")</script>';
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
	  
	  if ($_POST['table'] == "") $redirect_name = "payment";
	  else $redirect_name = $_POST['table'];
	  $redirect_str = "<script>window.location.href='http://hcytt1.mercury.nottingham.edu.my/" . $redirect_name . ".php';</script>";
	  echo $redirect_str;
      exit();
  } 
}
?>

</body>
</html>