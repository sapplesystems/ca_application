<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>CA Billing - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('public/assets/style.css'); ?>">

</head>
<body class="login-body">
  <div class="pattern-overlay"></div>

  <div class="login-wrapper">
    <div class="logo-row">
      <div class="logo-mark">CA</div>
      <div>
        <div class="logo-text-main">Kumar Samantaray &amp; Associates</div>
        <div class="logo-text-sub">Chartered Accountants</div>
      </div>
    </div>

    <div class="login-title">Sign in to CA Billing</div>
    <div class="login-subtitle">Enter your credentials to access dashboard &amp; billing.</div>
<?php if(session()->getFlashdata('success')): ?>
    <div style="color: green; padding: 10px;">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div style="color: red; padding: 10px;">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
    <form id="loginForm" action="<?= site_url('login-for-entry'); ?>" method="POST">
      
  <div class="form-group">
    <label for="username">User ID / Email</label>
    <input id="username" name="username" class="input" type="text" value="<?= old('username') ?>" placeholder="e.g. rajesh.kumar" />
    <small class="error-msg" id="usernameError"></small>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input id="password" class="input" name="pass" type="password" placeholder="••••••••" />
    <small class="error-msg" id="passwordError"></small>
  </div>

  <div class="row-between">
    <label>
      <input type="checkbox" />
      Remember me
    </label>
    <a href="#">Forgot password?</a>
  </div>

  <button type="submit" class="btn-login">Login</button>

  <div class="footer-text">
    © 2025 Kumar Samantaray &amp; Associates. All rights reserved.
  </div>
</form>

  </div>
  <script>
  const form = document.getElementById('loginForm');
  const username = document.getElementById('username');
  const password = document.getElementById('password');
  const usernameError = document.getElementById('usernameError');
  const passwordError = document.getElementById('passwordError');

  form.addEventListener('submit', function (e) {
    // prevent submit first
    e.preventDefault();

    let isValid = true;

    // reset previous errors
    username.classList.remove('input-error');
    password.classList.remove('input-error');
    usernameError.textContent = '';
    passwordError.textContent = '';

    if (username.value.trim() === '') {
      username.classList.add('input-error');
      usernameError.textContent = 'User ID / Email is required';
      isValid = false;
    }

    if (password.value.trim() === '') {
      password.classList.add('input-error');
      passwordError.textContent = 'Password is required';
      isValid = false;
    }

    // if both filled, you can submit (for CodeIgniter use form.submit())
    if (isValid) {
      form.submit();
    }
  });
</script>

</body>
</html>
