<?php require ("inc/head.php"); ?>
<?php require ("inc/nav.php"); ?>

<?php
if (isset ($_COOKIE['user_id']) || isset ($_COOKIE['user_email']) || isset ($_SESSION['user_id']) || isset ($_SESSION['email'])) {
  header("location: ./index.php");
  exit;
} ?>

<div class="section">
  <div class="forms">
    <div class="signup-form">
      <form action="#" method="post" class="form-group" onsubmit="return checkPassword()">
        <div class="head">
          <h3>Login</h3>
        </div>
        <?php if (isset ($_GET['err'])) { ?>
          <div class="alert alert-danger" style="font-weight:450;"><small>
              <?php echo $_GET['err']; ?>
            </small></div>
        <?php } else if (isset ($_GET['msg'])) { ?>
            <div class="alert alert-success acctcreated" style="font-weight:450;"><small>
              <?php echo $_GET['msg']; ?>
              </small></div>
        <?php } ?>

        <input type="email" placeholder="Email" name="email" class="form-control inp-email mt-2">

        <input type="password" id="passwordInput" placeholder="Password" name="pwd" class="form-control inp-pwd mt-2">

        <input type="submit" name="loginbtn" class="btn btn-info mt-2 btn-block" value="Login">
      </form>
      <div id="bruteForceResult"
        style="text-align: center; font-size: 24px; margin-top: 20px; display: none; color: white;"></div>
    </div>
  </div>
</div>

<?php require ("inc/footer.php"); ?>

<script>
  function bruteForce(password) {
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+*~!@#$%^&()_-={}[]|;:<>,.?/';
    var startTime = Date.now();

    function generateCombinations(length, prefix) {
      if (length === 0) {
        if (prefix === password) {
          var endTime = Date.now();
          var timeDiff = endTime - startTime;
          var timeFormatted = timeDiff.toFixed(2);

          var resultDiv = document.getElementById("bruteForceResult");
          resultDiv.style.display = "block";
          resultDiv.style.backgroundColor = "gray";
          resultDiv.style.fontWeight = "bold";
          resultDiv.innerHTML = "Mot de passe trouvé par force brute : " + prefix + "<br>Temps nécessaire : " + timeFormatted + " millisecondes.";
          return true;
        }
        return false;
      }
      for (var i = 0; i < characters.length; i++) {
        if (generateCombinations(length - 1, prefix + characters[i])) {
          return true;
        }
      }
      return false;
    }

    generateCombinations(password.length, '');
    return false;
  }

  function dictionary(password) {
    var dictionary = ["000", "001", "010", "011", "100", "101", "110", "111"];
    if (dictionary.includes(password)) {
      var resultDiv = document.getElementById("bruteForceResult");
      resultDiv.style.display = "block";
      resultDiv.style.backgroundColor = "gray";
      resultDiv.style.fontWeight = "bold";
      resultDiv.innerHTML = "Mot de passe trouvé dans le dictionnaire : " + password;
      return false;
    }
    return true;
  }

  function checkPassword() {
    var password = document.getElementById("passwordInput").value;
    if (password.length === 5) {
      return bruteForce(password);
    } else if (password.length === 3) {
      return dictionary(password);
    } else {
      alert("La longueur du mot de passe doit être de 3 ou 5 caractères.");
      return false;
    }
  }
</script>