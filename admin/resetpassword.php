<?php
require_once __DIR__ . '/config/conn.php';

$message = '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';
$reset_is_valid = isset($_SESSION['password_reset_user'], $_SESSION['password_reset_token'], $_SESSION['password_reset_expires'])
  && hash_equals($_SESSION['password_reset_token'], $token)
  && time() <= (int) $_SESSION['password_reset_expires'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $reset_is_valid) {
  $password = (string) ($_POST['password'] ?? '');
  $password_confirmation = (string) ($_POST['password_confirmation'] ?? '');

  if (strlen($password) < 8) {
    $message = 'Password must be at least 8 characters.';
  } elseif ($password !== $password_confirmation) {
    $message = 'Passwords do not match.';
  } else {
    $user_id = (int) $_SESSION['password_reset_user'];
    $statement = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
    if ($statement) {
      $password_hash = md5($password);
      $statement->bind_param('si', $password_hash, $user_id);
      $statement->execute();
    }

    unset($_SESSION['password_reset_user'], $_SESSION['password_reset_token'], $_SESSION['password_reset_expires']);
    header('Location: login.php?msg=' . urlencode('Password changed successfully.'));
    exit;
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $message = 'This reset link is invalid or has expired.';
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
    <a href="index.php"><b>Reset Password</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Choose a new admin password.</p>

    <?php if ($message !== ''): ?>
      <p class="text-center text-danger"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form action="" method="post">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="New password" minlength="8" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" minlength="8" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">

          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Change Password</button>
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
