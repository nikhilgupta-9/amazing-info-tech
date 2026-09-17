<?php
require_once __DIR__ . '/config/conn.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = 'Please enter a valid email address.';
  } else {
    $statement = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    if ($statement) {
      $statement->bind_param('s', $email);
      $statement->execute();
      $statement->store_result();
    }

    if ($statement && $statement->num_rows === 1) {
      $statement->bind_result($user_id);
      $statement->fetch();
      $_SESSION['password_reset_user'] = (int) $user_id;
      $_SESSION['password_reset_token'] = bin2hex(random_bytes(32));
      $_SESSION['password_reset_expires'] = time() + 900;
      header('Location: resetpassword.php?token=' . urlencode($_SESSION['password_reset_token']));
      exit;
    }

    $message = 'No admin account was found for that email address.';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="forgotpassword.php"><b>Forgot Password</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Enter your admin email to reset the password.</p>

    <?php if ($message !== ''): ?>
      <p class="text-center text-danger"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form action="" method="post">
       <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
           <a href="login.php" class="text-center">Back to login</a>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Now</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
