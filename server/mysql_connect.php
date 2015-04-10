<?php
  //create file database_account.php have content
  //<?php
  // $host = "host";
  // $root = "root";
  // $password = "password";
  // $database = "database";
  //
  require('database_account.php');

  $con=mysqli_connect($host, $root, $password, $database);
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  function query($sql) {
    global $con;
    return mysqli_query($con, $sql);
  }

  function fetch_row($res) {
    return mysqli_fetch_array($res);
  }

  function params($key) {
    if($_GET[$key]) {
      return $_GET[$key];
    } else {
      return $_POST[$key];
    }
  }

  function escape_params($key) {
    return escape(params($key));
  }

  function escape($str) {
    // return $str;
    return mysql_escape_string((string) $str);
  }
?> 