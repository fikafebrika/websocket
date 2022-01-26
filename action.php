<?php
  session_start();
  if(isset($_POST['action']) && $_POST['action'] == 'leave') {
    require("db/users.php");

    $tz = 'Asia/Jakarta';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz));
    $dt->setTimestamp($timestamp);

    $objUser = new users;
    $objUser->setLoginStatus(0);
    $objUser->setLastLogin($dt->format('Y-m-d h:i:s'));
    $objUser->setId($_POST['userId']);
    if($objUser->updateLoginStatus()) {
      unset($_SESSION['user']);
      session_destroy();
      echo json_encode(['status'=>1, 'msg'=>"Logout.."]);
    } else {
      echo json_encode(['status'=>0, 'msg'=>"Something went wrong.."]);
    }
  }
?>