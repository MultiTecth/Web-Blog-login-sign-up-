<?php
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['pw'])){

  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $unameTest = $_POST['uname'];
  if($unameTest == trim($uname) && str_contains($unameTest, ' ')){
    header("Location: index.php?error=Username not accepted space letter");
    exit();
  }else {
    $uname = validate($unameTest);
  }
  $pass = validate($_POST['pw']);

  if (empty($uname)){
    header("Location: index.php?error=Username is required");
    exit();
  } 
  else if(empty($pass)){
    header("Location: index.php?error=Password is required");
    exit();
  } 
  else {
    $sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1){
      $row = mysqli_fetch_assoc($result);

      if($row['user_name'] === $uname && $row['password'] === $pass){
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];

        


        header("Location: ../home/index.php");
        exit();
      }
      else {
        header("Location: index.php?error=Incorect username or password");
        exit();
      }
    }

    else {    
      header("Location: index.php?error=Incorect username or password");
      exit();
    }
  }

} 
else {
  header("Location: index.php");
  exit();
}

?>