<html>
<body>

<h1>Database: Entertainment</h1>

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