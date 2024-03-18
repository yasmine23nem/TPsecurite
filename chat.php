  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="Home Page" />
    <title>Chatpro | Chat</title>
    <!-- css and bootstrap -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- boostrap js and jqouery -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- chart.css -->
    <!-- js files -->
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- icon script -->
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
  </head>
  <body>

  <?php 

  require("config/db.php");

  if(isset($_GET['uid'])){
    $user_email = $_COOKIE['email'];
    $user_id = $_COOKIE['user_id'];

    $chat_user_id = $_GET['uid'];
    // query user
    $query_user = mysqli_query($conn, "SELECT * FROM user_info WHERE userId='$chat_user_id'");

    if(mysqli_num_rows($query_user) > 0){
      $data = mysqli_fetch_assoc($query_user);
      $username = $data['username'];
      $userimg = $data['user_img'];
      $status = $data['status'];
      $date = $data['active_at'];
    }else{
      header("location: login.php");
      die;
    }
  }else{
    header("location: login.php");
    die;
  }

  ?>

  <section class="chat-section">
      <div class="chat-card">
        <!-- chat header -->
        <div class="chat-card-head">
          <div class="user-info">
            <?php if($status === "On"){?>
              <a class="mr-2 p-0" href="index.php">
                <ion-icon name="arrow-back-outline" style="font-size:20px; color:#fff;"></ion-icon>
              </a>
              <div class="user-img" style="background: url(user_img_uploads/<?php echo $userimg; ?>); background-size:cover; background-position:center;"></div>
              <br>
              <p class="username"><?php echo $username; ?></p>
              <br>
              <br>
              <br>
              <sup><ion-icon class="online-circle ml-1" name="ellipse"></ion-icon></sup>
            <?php }else if($status === "Off"){?>
              <a class="mr-2 p-0" href="index.php">
                <ion-icon name="arrow-back-outline" style="font-size:20px; color:#fff;"></ion-icon>
              </a>
              <div class="user-img" style="background: url(user_img_uploads/<?php echo $userimg; ?>); background-size:cover; background-position:center;"></div>
              <br>
              <p class="username"><?php echo $username; ?></p>
              <br>
              <br>
              <sup><ion-icon class="offline-circle ml-1" name="ellipse"></ion-icon></sup>
          
 

            <?php }?>
          </div>
        </div>

        <!-- chat body -->
        <div class="chat-body">
          <div class="chat-msg-ovl">
            <p>No messages available, stat a chat.</p>
          </div>

          <div class="chat-msg"></div>

          <!-- chat footer -->
          <div class="chat-footer">
            <div class="form-inline mt-1 input-group p-1">
              <input type="text" class="send-msg form-control" placeholder="Send message" id="send-msg-inp">

              <?php 
              require_once("config/db.php");
              $user_id = $_GET['uid'];

              $query = mysqli_query($conn, "SELECT * FROM user_info WHERE userId='$user_id'");

              $count = mysqli_fetch_assoc($query);
              if($count == 0){
                  header("location: users.php");
                  die;
              }else if($count > 0){?>
                  <input type="hidden" value="<?php echo $user_id;?>" id="incoming_id_inp">
              <?php }?>
              <div class="form-check form-check-inline">

        
              <select name="encryptionMethod" id="encryptionMethod">
                    <option value="cesar">César</option>
                    <option value="shift">Décalage</option>
                    <option value="affine">Affine</option>
                </select>
                <input type="number" id="cesarShiftInput" style="display: none;" placeholder="Cesar Shift">
                <select id="cesarDirectionInput" style="display: none;">
                  <option value="droite">Droite</option>
                  <option value="gauche">Gauche</option>
                </select>
                <input type="number" id="shiftInput" style="display: none;" placeholder="Shift"> 
                <input type="number" id="affineInputA" style="display: none;" placeholder="Affine A">
                <input type="number" id="affineInputB" style="display: none;" placeholder="Affine B"> 
                
                
                <button class="send-btn btn btn-primary" type="submit" id="send-btn">
                    Send
                </button>
                <p id="error-message" style="color: red;"></p>
              </div>
          </div>
        </div>
      </div>
  </section>

  <script src="js/fetch_msg.js"></script>

<!-- Add two new input fields for a and b -->
<script>
document.getElementById('encryptionMethod').addEventListener('change', function() {
  var shiftInput = document.getElementById('shiftInput');
  var cesarShiftInput = document.getElementById('cesarShiftInput');
  var cesarDirectionInput = document.getElementById('cesarDirectionInput');
  var affineInputA = document.getElementById('affineInputA');
  var affineInputB = document.getElementById('affineInputB');

  if (this.value === 'shift') {
    shiftInput.style.display = 'inline-block';
    cesarShiftInput.style.display = 'none';
    cesarDirectionInput.style.display = 'none';
    affineInputA.style.display = 'none';
    affineInputB.style.display = 'none';
  } else if (this.value === 'cesar') {
    shiftInput.style.display = 'none';
    cesarShiftInput.style.display = 'inline-block';
    cesarDirectionInput.style.display = 'inline-block';
    affineInputA.style.display = 'none';
    affineInputB.style.display = 'none';
  } else if (this.value === 'affine') {
    shiftInput.style.display = 'none';
    cesarShiftInput.style.display = 'none';
    cesarDirectionInput.style.display = 'none';
    affineInputA.style.display = 'inline-block';
    affineInputB.style.display = 'inline-block';
  } else {
    shiftInput.style.display = 'none';
    cesarShiftInput.style.display = 'none';
    cesarDirectionInput.style.display = 'none';
    affineInputA.style.display = 'none';
    affineInputB.style.display = 'none';
  }
});
</script>
  </body>
  </html>