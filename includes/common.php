  <?php

  /*Declaring the constants to be used*/
  define("HOST", "localhost");
  define("USERNAME", "UsernNameCreatedAsRequested");
  define("PASSWORD","UserNamePassword");
  define("DB", "pizza_store");

  /*Function which creates and returns the connection made*/
  function connectToDB() {
    try {
      /* Connecting using PDO*/
      $conn = new PDO("mysql:host=".constant('HOST').";dbname=".constant('DB'), constant("USERNAME"), constant("PASSWORD"));  
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      /* Throwing potential errors */
      } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
      die();
    }

    return $conn;
  }

  
  /* CONNECTION TEST MADE DURING DEV (TO BE DELETED!!!)
  define("HOST", "localhost");
  define("USERNAME", "lamp1user");
  define("PASSWORD","123456");
  define("DB", "testedatabase");

  $connection = connectToDB(HOST, USERNAME, PASSWORD, DB);
  $test = $connection->query('select * from MyGuests')->fetch();
  echo $test['firstname'];
  */

  ?>

