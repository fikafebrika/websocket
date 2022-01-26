<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat application in php using web socket programming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="jquery-3.6.0.min.js"></script>
    <style type="text/css">
      #messages {
        min-height: 100px;
        background: whitesmoke;
        overflow: auto;
      }
      #chat-room-frm {
        margin-top: 10px;
      }
      #send {
        width: 100%;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2 class="text-center mt-3 pt-0">Chat application in PHP & MySQL using Ratchet Library</h2>
      <h3 class="text-center mt-3 pt-0">Part 3: Design chatroom page</h3>
      <hr>
      <div class="row">
        <div class="col-md-4">
          <?php
            session_start();
            if(!isset($_SESSION['user'])) {
              header("location: index.php");
            }
            require("db/users.php");
            require("db/chatrooms.php");

            $objChatroom = new chatrooms;
            $chatrooms = $objChatroom->getAllChatRooms();

            $objUser = new users;
            $users = $objUser->getAllUsers();
          ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <td>
                  <?php
                    foreach ($_SESSION['user'] as $key => $user) {
                      $userId = $key;
                      echo '<input type="hidden" name="userId" id="userId" value="'.$key.'">';
                      echo "<div>".$user['name']."</div>";
                      echo "<div>".$user['email']."</div>";
                    }
                  ?>
                </td>
                <td align="right" colspan="2">
                  <input type="button" class="btn btn-warning" id="leave-chat" nama="leave-chat" value="Leave">
                </td>
              </tr>
              <tr>
                <th colspan="2">Users</th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($users as $key => $user) {
                  $color = "bg-danger";
                  if($user['login_status'] == 1) {
                    $color = "bg-success";
                  }
                  if(!isset($_SESSION['user'][$user['id']])) {
                    echo "<tr><td>".$user['name']."</td>";
                    echo "<td class=".$color.">".$user['last_login']."</td></tr>";  
                  }
                }
              ?>              
            </tbody>
          </table>
        </div>
        <div class="col-md-8">
          <div id="messages">
            <table id="chats" class="table table-striped">
              <thead>
                <tr>
                  <th colspan="4" scope="col"><strong>Chat Room</strong></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($chatrooms as $key => $chatroom) {
                    if($userId == $chatroom['userid']) {
                      $from = "Me";
                    } else {
                      $from = $chatroom['name'];
                    }
                    echo '<tr><td valign="top"><div><strong>'.$from.'</strong></div><div>'.$chatroom['msg'].'</div><td align="right" valign="top">'.$chatroom['created_on'].'</td></tr>';
                  }
                ?>
              </tbody>
            </table>
          </div>

          <form action="" method="post" id="chat-room-frm">
            <div class="form-group">
              <textarea name="msg" id="msg" class="form-control" placeholder="Enter Message"></textarea>
            </div>
            <div class="form-group pt-2">
              <input type="button" value="Send" name="send" class="btn btn-success" id="send">
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript">
    $(document).ready(function() {
      var conn = new WebSocket('ws://localhost:8080');
      conn.onopen = function(e) {
        console.log("Connection established!");
      };

      conn.onmessage = function(e) {
        console.log(e.data);
        var data = JSON.parse(e.data);
        var row = '<tr><td valign="top"><div><strong>' + data.from + '</strong></div><div>' + data.msg + '</div><td align="right" valign="top">' + data.dt + '</td></tr>';
        $('#chats > tbody').prepend(row);
      };

      conn.onclose = function(e) {
        console.log("Connection Closed!");
      }

      $("#send").click(function() {
        var userId = $("#userId").val();
        var msg = $("#msg").val();
        var data = {
          userId: userId,
          msg: msg
        };
        conn.send(JSON.stringify(data));
        $("#msg").val("");
      });

      $("#leave-chat").click(function() {
        var userId = $('#userId').val();
        $.ajax({
          url : "action.php",
          method : "post",
          data : "userId=" + userId + "&action=leave"
        }).done(function(result) {
          var data = JSON.parse(result);
          if(data.status == 1) {
            location = "index.php";
          } else {
            console.log(data.msg);
          }
        });
      })
    })
  </script>
</html>