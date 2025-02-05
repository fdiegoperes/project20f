<?php
include('includes/header.php');
include('includes/multifunction.php');
include('includes/security.php');

$orderid = 0;
if (isset($_GET["oid"])){
    $orderid = $_GET["oid"];
    
    $qry = 'Select tblOrders.orderDate, tblPizza.pizzaId, tblPizza.dough, tblPizza.cheese, tblPizza.sauce, tblPizza.toppings  ';
    $qry .= ' FROM tblOrders inner join tblPizzaOrders on tblPizzaOrders.orderId=tblOrders.orderId ';
    $qry .= ' inner join tblPizza on tblPizzaOrders.pizzaId = tblPizza.pizzaId ';
    $qry .= " WHERE tblOrders.orderId= ".$orderid;
    
    $qrycust = 'Select tblCustomers.address';
    $qrycust .= ' FROM tblOrders inner join tblCustomers on tblOrders.email=tblCustomers.email ';
    $qrycust .= " WHERE tblOrders.orderId= ".$orderid;
    
}

$multRec = $conn->prepare($qry);
$singleRec = $conn->prepare($qry);
$cust = $conn->prepare($qrycust);

if (!$multRec){
    echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
    exit(1);
}
if (!$singleRec){
    echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
    exit(1);
}
if (!$cust){
    echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
    exit(1);
}
$status = $multRec->execute();

if ($status){
    
    $singleRec->execute();
    $cust->execute();
    $ressingleRec = $singleRec->fetch(PDO::FETCH_ASSOC);
    $resCust = $cust->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content" >
     <div class="content">
    <h1 class="welcome-text">Here is your Order Summary <?php
    $helloName = selectCustomer();
    if ($helloName != "") {
        echo $helloName;
    } else {
        echo $_SESSION['email'];
    }?></h1>
    
<?php     
    echo '<h3>Order Summary Order ID: ' .$orderid. '</h3>';
    echo '<h4>Date of Order: ' .$ressingleRec['orderDate']. '</h4>';

    if ($multRec->rowCount() > 0){
        $cnt = 0;
        ?>
    		<table border="1" >
			<tr><th>Item No</th><th>Order Id</th><th>Dough</th><th>Cheeese</th><th>Sauce</th><th>Toppings</th></tr>
<?php while ($row = $multRec->fetch(PDO::FETCH_ASSOC)){ 
    $cnt++; 
    ?>
		<tr>
			<td><?php echo $cnt; ?></td>
			<td><?php echo $row['pizzaId']; ?></td>
			<td><?php echo $row['dough']; ?></td>
			<td><?php echo $row['cheese']; ?></td>
			<td><?php echo $row['sauce']; ?></td>
			<td><?php 
			$arr = str_replace("[","",$row['toppings']);
			$arr = str_replace("]","",$arr);
			//echo $arr;
			$toppings = json_decode($arr, true);
// 			print_r($my_array_data);
//              $arr = str_replace("[{","",$row['toppings']);
//              $arr = str_replace("}]","",$arr);
//              $arr = str_replace('"',"",$arr);
//              $arr = str_replace(" ","<br>",$arr);
//              $string = "";
// 			$toppings = explode(",",$arr);
			$string = "";
			foreach($toppings as $topping){
			    $string  .= ' ' . $topping;
			}
			echo  $string;
			?></td>
		</tr>
<?php } ?>
			</table><br><br>Please note: 
Pizza will be ready in 40 minutes and will be delivered to Address: <?php echo $resCust['address'] ?><br><br>
			<a href="orderPizza.php" class="button button-confirm">Return to Order page</a> <br><br>
<?php
		} else {
			echo "<div>\n";
			echo "<p>No order details to display</p>\n";
			echo "</div>\n";
		}
	} else {
		echo "<p>Error in display execute ".$stmt->errorCode()."</p>\n<p>Message ".implode($stmt->errorInfo())."</p>\n";
		exit(1);
	}

?>

</div>
</div>

</body>
</html>
