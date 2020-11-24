<?php 
	session_start(); 
	require_once("./includes/common.php");
?>

<html>
<head>
	<title>Project Pizza Store</title>
<!--
This form will be linked to index.php
when email exists, then click begin button to go to orderPizza -> summaryOrder 
when email user not exists, create new email button to link to this form -> a new customer fills out all fields and submit if no error
-->
</head>
<body>
	<h3>User Information</h3>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$err_msg = validate_form_1();
		if (count($err_msg) > 0){
			display_error($err_msg);
   			form_1( $_POST['email'],$_POST['name'], $_POST['address'], $_POST['phone'], $_POST['city'], $_POST['province'], $_POST['postalCode']);
	 	} else //no error
        {
			insert_data();
			display_data();
		}
	} else {
		//display form_1 
		form_1();
	}
?>

</body>
</html>

<?php function display_data(){ ?>
	<h3>POST Data</h3>
	<pre>
<?php print_r($_POST);  ?>
	</pre>
<?php } ?>

<?php function form_1($email = "", $name = "", $address = "", $phone="",$city="", $province="", $postalCode=""){ ?>
	<form method="POST" action="./userInformation.php">
		<label for="email">Email</label>
		<input type="email" size="50" maxlength="50" id ="email" name="email" value="<?php echo $email; ?>"></input><br>
        <br>
		<label for="name">Name: </label>
		<input type="text" size="40" maxlength="40" id ="name" name="name" value="<?php echo $name; ?>"></input><br>
        <br>
        <label for="address">Address</label>
		<input type="text" size="60" maxlength="60" id ="address" name="address" value="<?php echo $address; ?>"></input><br>
        <br>
        <label for="city">City</label>
		<input type="text" size="20" maxlength="20" id ="city" name="city" value="<?php echo $city; ?>"></input><br>
        <br>
        <label for="province">Province</label>
		<input type="text" size="20" maxlength="20" id ="province" name="province" value="<?php echo $province; ?>"></input><br>
        <br>
        <label for="postalCode">Postal Code</label>
		<input type="text" size="15" maxlength="15" id ="postalCode" name="postalCode" value="<?php echo $postalCode; ?>"></input><br>
        <br>
        <label for="phone">Phone</label>
		<input type="tel" size="20" maxlength="20" id ="phone" name="phone" value="<?php echo $phone; ?>"></input><br>
        <br>
		<input type="submit" value="Submit"/>
	</form>

<?php } ?>

<?php  

//alert error message
function display_error($error_msg){
	echo "<p>\n";
	foreach($error_msg as $v){
		echo "<script type='text/javascript'>alert('$v');</script>";
	}
	echo "</p>\n";
}

//validate_form_1: check fields
function validate_form_1(){
	$error_msg = array();
   if ($_SESSION['email'] == $_POST['email']){
         $error_msg[] = "Email exists, enter a new email";
    }
    
    else {
   //check email field not empty and not > length of db
	if (!isset($_POST['email'])){
		$error_msg[] = "Email field not defined";
	} else if (isset($_POST['email'])){         
		$email = trim($_POST['email']);
		if (empty($email)){
			$error_msg[] = "The email field is empty";
		} else if (strlen($email) >  50){
			$error_msg[] = "The email address is too long";
		} else {
			$tmp_email = filter_var($email, FILTER_VALIDATE_EMAIL);
			if (!$tmp_email){
				$error_msg[] = "Invalid email address entered";
			}
		}
	}//else if

}
    //check name field not empty and not > length of db
	if (!isset($_POST['name'])){
		$error_msg[] = "Name field not defined";
	} else if (isset($_POST['name'])){
		$name = trim($_POST['name']);
		if (empty($name)){
			$error_msg[] = "The name field is empty";
		} else {
			if (strlen($name) >  40){
				$error_msg[] = "The name field contains too many characters";
			}
		}
	}
    
     //check address field not empty and not > length of db
    if (!isset($_POST['address'])){
		$error_msg[] = "Address field not defined";
	} else if (isset($_POST['address'])){
		$address= trim($_POST['address']);
		if (empty($address)){
			$error_msg[] = "The address field is empty";
		} else {
			if (strlen($address) >  50){
				$error_msg[] = "The address field contains too many characters";
			}
		}
	}

    //check phone field not empty and not > length of db
    if (!isset($_POST['phone'])){
		$error_msg[] = "phone field not defined";
	} else if (isset($_POST['phone'])){
		$phone = trim($_POST['phone']);
		if (empty($phone)){
			$error_msg[] = "The phone field is empty";
		} else if (strlen($phone) >  20){
			$error_msg[] = "The phone field contains too many characters";
		} 
	}

       //check city field not empty and not > length of db
    if (!isset($_POST['city'])){
		$error_msg[] = "City field not defined";
	} else if (isset($_POST['city'])){
		$city= trim($_POST['city']);
		if (empty($city)){
			$error_msg[] = "The city field is empty";
		} else {
			if (strlen($city) >  20){
				$error_msg[] = "The city field contains too many characters";
			}
		}
	}

      //check province field not empty and not > length of db
    if (!isset($_POST['province'])){
		$error_msg[] = "Province field not defined";
	} else if (isset($_POST['province'])){
		$province= trim($_POST['province']);
		if (empty($province)){
			$error_msg[] = "The province field is empty";
		} else {
			if (strlen($province) >  20){
				$error_msg[] = "The province field contains too many characters";
			}
		}
	}

   //check postalCode field not empty and not > length of db
    if (!isset($_POST['postalCode'])){
		$error_msg[] = "postalCode field not defined";
	} else if (isset($_POST['postalCode'])){
		$postalCode= trim($_POST['postalCode']);
		if (empty($postalCode)){
			$error_msg[] = "The postalCode field is empty";
		} else {
			if (strlen($postalCode) >  15){
				$error_msg[] = "The postalCode field contains too many characters";
			}
		}
	}
 
    
	if (count($error_msg) == 0){
		$_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['address'] = $address;
        $_SESSION['phone'] = $phone;
        $_SESSION['city'] = $city;
        $_SESSION['province'] = $province;
        $_SESSION['postalCode'] =$postalCode;
        
	}
	return $error_msg;
} 

//insert new value to tblCustomers in pizza_store_db database
function insert_data(){
	$dbc = connectToDB();

	$stmt = $dbc->prepare('INSERT INTO tblCustomers(email, nameCustomer, address, phone, city, province, postalCode) values(:email, :name, :address, :phone, :city, :province, :postalCode)');
	if (!$stmt){
		echo "Error ".$dbc->errorCode()."\nMessage ".implode($dbc->errorInfo())."\n";
		exit(1);
	}

	$email = $_SESSION['email'];
    $name=$_SESSION['name'];
    $address=$_SESSION['address'];
    $phone = $_SESSION['phone'];
    $city=$_SESSION['city'];
    $province=$_SESSION['province'];
    $postalCode=$_SESSION['postalCode'];

	$data = array(":email" => $email, ":name"=>$name,":address"=>$address, ":phone" => $phone, ":city"=>$city,":province"=>$province,":postalCode"=>$postalCode);

	$status = $stmt->execute($data);
	if(!$status){
		echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
		exit(1);
	}
	$dbc = NULL;
}
?>
