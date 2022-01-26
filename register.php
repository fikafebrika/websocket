<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Chat Widget</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h2 class="text-center mt-3 pt-0">Chat application in PHP & MySQL using Ratchet Library</h2>
      <h3 class="text-center mt-3 pt-0">Register</h3>
      <hr>
      <?php
        if(isset($_POST['join'])) {
          session_start();
          require("db/users.php");

          $tz = 'Asia/Jakarta';
          $timestamp = time();
          $dt = new DateTime("now", new DateTimeZone($tz));
          $dt->setTimestamp($timestamp);
          
          $objUser = new users;
          $objUser->setEmail($_POST['email']);
          $objUser->setName($_POST['uname']);
          $objUser->setLoginStatus(1);
          $objUser->setLastLogin($dt->format('Y-m-d h:i:s'));
          $userData = $objUser->getUserByEmail();
          if($objUser->save()) {
            $lastId = $objUser->dbConn->lastInsertId();
            $objUser->setId($lastId);
            $_SESSION['user'][$userData['id']] = (array)$objUser;
            echo "User Registered..";
            header("location: index.php");
          } else {
            echo "Failed..";
          }  
        }
      ?>

      <div class="row justify-content-center join-room">
        <div class="col-md-6">
          <form role="form" method="post" action="" id="join-room-frm" class="form-horizontal">
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" id="uname" name="uname" placeholder="Enter Name">
              </div>
            </div>
            <div class="form-group pt-3">
              <div class="input-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" value="">
              </div>
            </div>
            <div class="form-group pt-3">
              <input type="submit" value="REGISTER" class="btn btn-success btn-block" id="join" name="join" style="width: 100%">
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>