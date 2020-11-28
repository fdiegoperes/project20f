<?php if(isset($_SESSION["email"])) { ?>
<div class="navigation">
    <ul>
        <li id="welcomeBack"><p> Welcome back, <?php echo $_SESSION['email'] ?></p></a>
        <li><a href="orderPizza.php">Order New Pizza</a></li>
        <li><a href="userInformation.php">My Account</a></li>
        <li><a href="previousOrders.php">Past Orders</a></li>
    </ul>
</div>
<?php } ?>
