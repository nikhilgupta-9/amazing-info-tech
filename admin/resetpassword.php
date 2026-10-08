<?php
require_once __DIR__ . '/config/conn.php';

$message = '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';
$reset_is_valid = isset($_SESSION['password_reset_user'], $_SESSION['password_reset_token'], $_SESSION['password_reset_expires'])
  && hash_equals($_SESSION['password_reset_token'], $token)
  && time() <= (int) $_SESSION['password_reset_expires'];

if (!$reset_is_valid && $_SERVER['REQUEST_METHOD'] !== 'POST') {
  $message = 'This reset link is invalid or has expired.';
}

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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    body.register-page {
      align-items: center;
      background: #f1f5f9;
      display: flex;
      justify-content: center;
      min-height: 100vh;
      padding: 24px;
    }

    .register-box {
      width: min(420px, 100%);
    }

    .register-logo {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 18px;
      text-align: center;
    }

    .register-logo a {
      color: #1f2937;
      text-decoration: none;
    }

    .register-box-body {
      background: #fff;
      border-radius: 8px;
      border-top: 4px solid #176b87;
      box-shadow: 0 12px 32px rgba(15, 23, 42, .1);
      color: #475569;
      padding: 28px;
    }

    .login-box-msg {
      color: #64748b;
      line-height: 1.5;
      margin: 0 0 22px;
      text-align: center;
    }

    .form-group.has-feedback {
      margin-bottom: 16px;
      position: relative;
    }

    .form-control {
      min-height: 44px;
      padding-right: 46px;
    }

    .form-control-feedback {
      align-items: center;
      color: #64748b;
      display: flex;
      height: 44px;
      justify-content: center;
      pointer-events: none;
      position: absolute;
      right: 0;
      top: 0;
      width: 42px;
    }

    .reset-actions {
      display: grid;
      gap: 16px;
      margin-top: 22px;
    }

    .reset-actions .btn {
      background: #176b87;
      border-color: #176b87;
      font-weight: 600;
      min-height: 44px;
    }

    .reset-back-link {
      color: #176b87;
      text-align: center;
      text-decoration: none;
    }

    .reset-back-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      body.register-page {
        padding: 16px;
      }

      .register-box-body {
        padding: 22px;
      }
    }
  </style>
</head>
<body class="register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="login.php">Reset Password</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Choose a new admin password. Use at least 8 characters.</p>

    <?php if ($message !== ''): ?>
      <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if ($reset_is_valid): ?>
    <form action="" method="post">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="New password" minlength="8" autocomplete="new-password" required>
        <i class="fa fa-lock form-control-feedback" aria-hidden="true"></i>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" minlength="8" autocomplete="new-password" required>
        <i class="fa fa-check-circle form-control-feedback" aria-hidden="true"></i>
      </div>
      <div class="reset-actions">
        <button type="submit" class="btn btn-primary w-100">Change Password</button>
        <a class="reset-back-link" href="login.php">Back to sign in</a>
      </div>
    </form>
    <?php else: ?>
      <a class="reset-back-link d-block" href="login.php">Back to sign in</a>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
