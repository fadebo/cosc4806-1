<?php 
require_once ('user.php');
session_start();
  $user = new User();
  if(isset($_POST['submit'])){
    if($_POST['username'] != "" || $_POST['password'] == "" || $_POST['password2'] == ""){
      try{
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $result = $user->validateUsername($username);
        if($result !== "Username already exists"){
          if($password == $password2){
            $password = md5($password);
            $user->create_user($username, $password);
            header("Location: /login.php");
          }else{
            $msg = "Passwords do not match";
            $_SESSION["msg"] = $msg;
            header("Location: /register.php");
          }
        }else{
          $msg = "Username already exists";
          $_SESSION["msg"] = $msg;
          header("Location: /register.php");
        }
        
      }catch(PDOException $e){
        $msg = "Error: " . $e->getMessage();
        $_SESSION["msg"] = $msg;
        header("Location: /register.php");
      }
    }else{
      $msg = "Please fill in all fields";
      $_SESSION["msg"] = $msg;
      header("Location: /register.php");
    }
    $_SESSION["msg"] = $msg;
  }
?>