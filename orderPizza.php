<?php
    include('includes/header.php');
    include('includes/multifunction.php');
    include('includes/security.php');
    
    $dough_error = $cheese_error = $sauce_error = $toppings_error = '';
    $dough = $cheese = $sauce = '';

    $toppings = $pizza = $pizza_order = $err_msgs = array();
    $numberOfPizza = 1;

    function validateForm() {

        global $toppings, $pizza, $pizza_order, $err_msgs, $dough_error, $cheese_error, $sauce_error, $toppings_error, $dough, $cheese, $sauce, $numberOfPizza;
    
        // VALIDATE DOUGH
        if(isset($_POST['dough'])) {
          $dough = trim($_POST['dough']);
        } else {
          $err_msgs[] = $dough_error = "Please select your favorite dough.";
        }
        
        // VALIDATE SAUCE
        if(isset($_POST['sauce'])) {
          $sauce = trim($_POST['sauce']);
        } else {
          $err_msgs[] = $sauce_error = "Please select your favorite sauce.";
        }

        // VALIDATE CHEESE
        if(isset($_POST['cheese'])) {
          $cheese = trim($_POST['cheese']);
        } else {
          $err_msgs[] = $cheese_error = "Please select your favorite cheese.";
        }
    
        // VALIDATE TOPPINGS
        if(isset($_POST['toppings'])) {
          if (count($_POST['toppings']) > 5) {
            $err_msgs[] = $toppings_error = 'Sorry, you can only select up to 5 toppings.';
          } else {
            $toppings[] = $_POST['toppings'];
          }
        } else {
          $err_msgs[] = $toppings_error = "Please select your favorite toppings.";
        }
          
        // ADD TO "CART" ($_SESSION)
        if((count($err_msgs) == 0)) {
          if (!isset($_SESSION['pizza_order'])) {
            $_SESSION['pizza_order'] = array(); 
          }
          array_push($_SESSION['pizza_order'],array($dough,$cheese,$sauce,json_encode($toppings)));
          $numberOfPizza++;
        }
    }
    
    // Function to check if each topping was selected in case of error
    function checkedToppings($param) {
        global $gtops;
        if (isset($_POST['toppings'])) {
            $gtops = $_POST['toppings'];
        }
        
        if (isset($gtops)) {
            foreach($gtops as $topping){
              if ($topping == $param){
                  return true;
              }
          }
      }
      return false;
    }

?>
<?php 
  // Call function to validate Form fields and add a new one
  if(isset($_POST['addPizzaToOrder'])) { 
    validateForm();
    $_SESSION["orderType"] = 'multiple';

  } else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completeOrder'])){
    // Call when Order is Completed 
    validateForm();
    if(!isset($_SESSION["orderType"])) {
      $_SESSION["orderType"] = 'single';
    }

    // Get all "CART" data and insert in the database
    if(isset($_SESSION['pizza_order'])) {
        
      // INSERT ORDERS - One row for the whole order
      $sql = 'Insert into tblOrders (email, orderDate) values (:email, :orderDate)';
      $insert = $conn->prepare($sql);
      if (!$insert){
        echo "Error ".$conn->errorCode()."\n Message ".implode($conn->errorInfo())."\n";
        exit(1);
      }

      $data = array(":email" => $_SESSION['email'], ":orderDate" => date("Y-m-d"));

      $status = $insert->execute($data);
      if(!$status){
        echo "Error ".$insert->errorCode()."\n Message ".implode($insert->errorInfo())."\n";
        exit(1);
      }
      
      // Storing the last ID used with AUTO_INCREMENT for tblOrders
      $lastOrderID = $conn->lastInsertId();
      
      // Storing the session before adding PIZZA
      $rows = $_SESSION['pizza_order'];

      foreach($rows as $row)
      {
          // INSERT PIZZA - One row for each selected pizza 
          $sql = 'Insert into tblPizza (dough, cheese, sauce, toppings) values (?, ?, ?, ?)';
          $insert = $conn->prepare($sql);
          if (!$insert){
            echo "Error ".$conn->errorCode()."\n Message ".implode($conn->errorInfo())."\n";
            exit(1);
          }

          $status = $insert->execute($row);
          if(!$status){
            echo "Error ".$insert->errorCode()."\n Message ".implode($insert->errorInfo())."\n";
            exit(1);
          }

          // Storing the last ID used with AUTO_INCREMENT for tblPizza
          $lastPizzaID = $conn->lastInsertId();

          // INSERT ORDERPIZZA - One row for each added pizza
          $sql = 'Insert into tblPizzaOrders (orderId, pizzaId) values (:orderID, :pizzaID)';
          $insert = $conn->prepare($sql);
          if (!$insert){
            echo "Error ".$conn->errorCode()."\n Message ".implode($conn->errorInfo())."\n";
            exit(1);
          }

          $data = array(":orderID" => $lastOrderID, ":pizzaID" => $lastPizzaID);

          $status = $insert->execute($data);
          if(!$status){
            echo "Error ".$insert->errorCode()."\n Message ".implode($insert->errorInfo())."\n";
            exit(1);
          }
          $_SESSION['orderId'] = $lastOrderID;
      }

      // Free Session and Post variables
      $_POST = array();
      unset($_SESSION['pizza_order']);
      
      $customerExist = selectCustomer();
     
      if (isset($customerExist)) {
          // call the orderSummary.php page if customer is complete and exist - according requirement
          echo "<script>window.open('orderSummary.php?oid=".$_SESSION['orderId']."','_self')</script>";
      } else {
        // call the userInformation.php page if customer is incomplete or does not exist - according requirement
        echo "<script>window.open('userInformation.php','_self')</script>";
      }
    }
  }
?>

<div class="main-content" >
  <div class="content">
  <h1 class="welcome-text">Please make your order <?php 
  $helloName = selectCustomer();
  if ($helloName != "") {
    echo $helloName;
  } else {
    echo $_SESSION['email'];
  }?></h1>

  <p class="blurb">Select your pizza number <?php echo $numberOfPizza; ?></p>

  <form method="post">

    <p>
      <label for="dough">Dough type</label><br>
      Neapolitan<input type="radio" id="neapolitan" name="dough" <?php if (isset($dough) && $dough=="neapolitan") echo "checked";?> value="neapolitan"></br>
      New York style<input type="radio" id="new-york-style" name="dough" <?php if (isset($dough) && $dough=="new-york-style") echo "checked";?> value="new-york-style"></br>
      Sicilian style<input type="radio" id="sicilian-style" name="dough" <?php if (isset($dough) && $dough=="sicilian-style") echo "checked";?> value="sicilian-style"></br>
      <span class="error" style="color:#B4000F;"> <?php echo $dough_error; ?></span>
    </p>

    </hr>

    <p>
      <label for="sauce">Sauce</label><br>
      Pesto<input type="radio" id="pesto" name="sauce" <?php if (isset($sauce) && $sauce=="pesto") echo "checked";?> value="pesto"></br>
      White Garlic Sauce<input type="radio" id="white-garlic-sauce" name="sauce" <?php if (isset($sauce) && $sauce=="white-garlic-sauce") echo "checked";?> value="white-garlic-sauce"></br>
      Garlic Ranch Sauce<input type="radio" id="garlic-ranch-sauce" name="sauce" <?php if (isset($sauce) && $sauce=="garlic-ranch-sauce") echo "checked";?> value="garlic-ranch-sauce"></br>
      <span class="error" style="color:#B4000F;"> <?php echo $sauce_error; ?></span>
    </p>

    </hr>

    <p>
      <label for="toppings">Toppings (Up to 5 options)</label><br>
      <input type="checkbox" id="potato" name="toppings[1]" value="potato" <?php if (checkedToppings("potato")) echo "checked" ?> >
      <label for="toppings">Potato</label>
      <input type="checkbox" id="sausage" name="toppings[2]" value="sausage" <?php if (checkedToppings("sausage")) echo "checked"?> >
      <label for="toppings">Sausage</label>
      <input type="checkbox" id="bacon" name="toppings[3]" value="bacon" <?php if (checkedToppings("bacon")) echo "checked"?>>
      <label for="toppings">Bacon</label>
      <input type="checkbox" id="mushroom" name="toppings[4]" value="mushroom" <?php if (checkedToppings("mushroom")) echo "checked"?>>
      <label for="toppings">Mushroom</label>
      <input type="checkbox" id="black-olives" name="toppings[5]" value="black-olives" <?php if (checkedToppings("black-olives")) echo "checked"?>>
      <label for="toppings">Black olives</label>
      <input type="checkbox" id="radicchio" name="toppings[6]" value="radicchio" <?php if (checkedToppings("radicchio")) echo "checked";?>>
      <label for="toppings">Radicchio</label>
      <input type="checkbox" id="anchovies" name="toppings[7]" value="anchovies" <?php if (checkedToppings("anchovies")) echo "checked";?>>
      <label for="toppings">Anchovies</label>
      <input type="checkbox" id="eggplant" name="toppings[8]" value="eggplant" <?php if (checkedToppings("eggplant")) echo "checked";?>>
      <label for="toppings">Eggplant</label>
      <input type="checkbox" id="pepperoni" name="toppings[9]" value="pepperoni" <?php if (checkedToppings("pepperoni")) echo "checked";?>>
      <label for="toppings">Pepperoni</label>
      <input type="checkbox" id="ham" name="toppings[10]" value="ham" <?php if (checkedToppings("ham")) echo "checked";?>>

      <label for="toppings">Ham</label>
      <span class="error" style="color:#B4000F;"> <?php echo $toppings_error; ?></span>
    </p>

    <p>
      <label for="cheese">Cheese type</label><br>
      Mozzarella<input type="radio" id="mozzarella" name="cheese" <?php if (isset($cheese) && $cheese=="mozzarella") echo "checked";?> value="mozzarella"></br>
      Cheddar<input type="radio" id="cheddar" name="cheese" <?php if (isset($cheese) && $cheese=="cheddar") echo "checked";?> value="cheddar"></br>
      Pecorino-Romano<input type="radio" id="pecorino-romano" name="cheese" <?php if (isset($cheese) && $cheese=="pecorino-romano") echo "checked";?> value="pecorino-romano"></br>
      <span class="error" style="color:#B4000F;"> <?php echo $cheese_error; ?></span>
    </p>

    </hr>
    <input type="submit" class="button button-confirm" id="completeOrder" name="completeOrder" value="Complete Order">
    <input type="submit" class="button button-confirm" id="addPizzaToOrder" name="addPizzaToOrder" value="Add another Pizza">
  </form>
  <br><br>
  </div>
</div>

</body>
</html>

