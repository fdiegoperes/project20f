<?php 
	include('includes/header.php');
	include('includes/multifunction.php');
	include('includes/security.php');
?>
<!--
This form will be linked to index.php
when email exists, then click begin button to go to orderPizza -> summaryOrder 
when email user not exists, create new email button to link to this form -> a new customer fills out all fields and submit if no error
-->

<div class="main-content" >
 <div class="content-user">
<h1 class="welcome-text">Please update your information<?php 
  $helloName = selectCustomer();
  if ($helloName != "") {
    echo $helloName;
  } else {
    echo $_SESSION['email'];
  }?></h1>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$err_msg = validate_form_1();
		if (count($err_msg) > 0){
			display_error($err_msg);
   			form_1( $_POST['name'], $_POST['address'], $_POST['phone'], $_POST['city'], $_POST['province'], $_POST['postalCode']);
	 	} else //no error
        {
			Update_data();
			// call the orderSummary.php page if customer is complete and exist - according requirement
			echo "<script>window.open('orderSummary.php?oid=".$_SESSION['orderId']."','_self')</script>";
		}
	} else {
		//display form_1 
		form_1();
	}
?>



<?php function form_1($name = "", $address = "", $phone="",$city="", $province="", $postalCode=""){ 

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        $qry = 'Select nameCustomer, address, phone, city, province, postalCode  ';
        $qry .= ' FROM tblCustomers ';
        $qry .= ' WHERE email ="'. $_SESSION['email'].'"; ';
        //echo $qry;
        
        $conn = connectToDB();
        $singleRec = $conn->prepare($qry);
        if (!$singleRec){
            echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
            exit(1);
        }
        
        $singleRec->execute();
        $singleRec = $singleRec->fetch(PDO::FETCH_ASSOC);
        
        $name = $singleRec['nameCustomer'];
        $address = $singleRec['address'];
        $phone = $singleRec['phone'];
        $city = $singleRec['city'];
        $province = $singleRec['province'];
        $postalCode = $singleRec['postalCode'];
    }
    ?>
	<form method="POST" action="./userInformation.php">
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
		<input type="submit" class="button button-confirm" name="Update" value="Update Information">
	</form>
<br><br>
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
	    $_POST['name'] = $name;
	    $_POST['address'] = $address;
	    $_POST['phone'] = $phone;
	    $_POST['city'] = $city;
	    $_POST['province'] = $province;
	    $_POST['postalCode'] =$postalCode;
        
	}
	return $error_msg;
} 

// update to tblCustomers in pizza_store_db database
function update_data(){
    $name=$_POST['name'];
    $address=$_POST['address'];
    $phone = $_POST['phone'];
    $city=$_POST['city'];
    $province=$_POST['province'];
    $postalCode=$_POST['postalCode'];
    
    $conn = connectToDB();
   
	$qry = 'UPDATE tblCustomers ';
	$qry .= 'SET nameCustomer="'.$name.'", address="'.$address.'", phone="'.$phone.'", city="'.$city.'", province="'.$province.'", postalCode="'.$postalCode.'" ';
	$qry .= ' WHERE email ="'. $_SESSION['email'].'"; ' ;
// 	echo $qry;
	$stmt = $conn->prepare($qry);
	if (!$stmt){
		echo "Error ".$dbc->errorCode()."\nMessage ".implode($dbc->errorInfo())."\n";
		exit(1);
	}

	$status = $stmt->execute();
	if(!$status){
		echo "Error ".$stmt->errorCode()."\nMessaege ".implode($stmt->errorInfo())."\n";
		exit(1);
	}
	$dbc = NULL;
}
?>
  </div>
</div>
</body>
</html>
