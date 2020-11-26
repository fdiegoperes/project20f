<?php
    include('includes/header.php');
    include('includes/multifunction.php');

    
    $qry = "Select tblCustomers.nameCustomer, tblCustomers.address, tblCustomers.phone, tblCustomers.email, tblOrders.orderId, tblOrders.orderDate";
    $qry .= ' FROM tblCustomers inner join tblOrders on tblCustomers.email = tblOrders.email';
    
    if((strlen($_SESSION['email']) > 0)){
        $qry .= " WHERE tblCustomers.email like '%".$_SESSION['email']."%'";
    }

    $stmt = $conn->prepare($qry);
    if (!$stmt){
        echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
        exit(1);
    }
    $status = $stmt->execute();
   
    if ($status){
       
        if ($stmt->rowCount() > 0){
            ?>
<div class="main-content" >
  <h1 class="welcome-text">Hello <?php 
  $helloName = selectCustomer();
  if ($helloName != "") {
    echo $helloName;
  } else {
    echo $_SESSION['email'];
  }?>, welcome to Previous Orders </h1>
           
			<table border="1">
			<tr><th>View Order Detail</th><th>Order Id</th><th>order Date</th></tr>
<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
			<tr>
			<td><a href="orderSummary.php?oid=<?php echo $row['orderId']; ?>">View Order Summary</a></td>
			<td><?php echo $row['orderId']; ?></td>
			<td><?php echo $row['orderDate']; ?></td>
			</tr>
<?php } ?>
			</table>
<?php
		} else {
			echo "<div>\n";
			echo "<p>No orders to display</p>\n";
			echo "</div>\n";
		}
	} else {
		echo "<p>Error in display execute ".$stmt->errorCode()."</p>\n<p>Message ".implode($stmt->errorInfo())."</p>\n";
		exit(1);
	}
?>