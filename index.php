<?php
    include('includes/header.php');
?>

<div class="main-content">
<h1 class="welcome-text">Welcome to IWD Pizzaria</h1>
<p class="blurb"> This web app will allow you to order pizza using our custom pizza builder</p>
<form action="index.php" method="post">
    <input class="text-input" type="text" name="email" placeholder="Enter your email address">
    <button class="button button-confirm" id="beginOrder" name="register">Begin Order</button>
</form>
</div>
<!-- TODO: Create a gallery of pizza to help eliminate whitespace -->
</body>
</html>

<?php 
    if(isset($_POST['register'])) {
        // Get posted email
        $user_email = $_POST['email'];
        
        // Verify if it already exists on the DB
        $select_user = "SELECT COUNT(*) FROM tblCustomers WHERE email='".$user_email."'";
        $verify_user = $conn->query($select_user)->fetchColumn();
        if($verify_user > 0) {

            $_SESSION['email'] = $user_email;
            echo "<script>window.open('orderPizza.php','_self')</script>";

        } else {
            // Inserting a new user
            $insert_user = "insert into tblCustomers (email) values(?) ";
            $conn->prepare($insert_user)->execute([$user_email]);
            $_SESSION['email'] = $user_email;
            echo "<script>alert('You have been registered Successfully!')</script>";
            echo "<script>window.open('orderPizza.php','_self')</script>";
        }
        
    }
?>
