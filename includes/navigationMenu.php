<?php if(isset($_SESSION["email"])) : ?>
<div class="navigation">
    <ul>
        <li id="welcomeBack"><p> Welcome back, <?php echo $_SESSION['email'] ?></p></a>
        <li><a href="orderPizza.php">Create New Order</a></li>
        <li><a href="userInformation.php">My Account</a></li>
    </ul>
</div>
<?php endif; ?>
