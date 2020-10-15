  <?php

  /*Declaring the constants to be used*/
  define("HOST", "localhost");
  define("USERNAME", "user1");
  define("PASSWORD","Windows123!");
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

  $conn = connectToDB();

  ?>

