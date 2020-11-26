<?php


function selectCustomer() {
    global $conn;
    
    // Select the customer in the database
    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        
        $sql = "SELECT nameCustomer FROM tblCustomers WHERE email = '$email';";
        
        $select = $conn->prepare($sql);
        if (!$select){
            echo "Error ".$conn->errorCode()."\n Message ".implode($conn->errorInfo())."\n";
            exit(1);
        }
        
        //$data = array(":email" => $_SESSION['email']);
        
        $result = $select->execute();
        $data = $select->fetch();
        
        if(!$result){
            echo "Error ".$select->errorCode()."\n Message ".implode($select->errorInfo())."\n";
            exit(1);
        }
        
        if ($data['nameCustomer'] != "") {
            return $data['nameCustomer'];
        }
    }
    
    // fetch to read each row and echo into the table
    /* while($row = $select->fetch()) { ?>
    
    <tr>
    <td><?php echo htmlspecialchars($row['car']) ?></td>
    <td><?php echo htmlspecialchars($row['make']) ?></td>
    <td><?php echo htmlspecialchars($row['model']) ?></td>
    <td><?php echo htmlspecialchars($row['year']) ?></td>
    </tr>
    
    <?php } //endwhile ?> */
}
?>