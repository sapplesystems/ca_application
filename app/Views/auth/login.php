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
            <div class="logo-mark"><img src="<?= base_url('public/images/CA_logo.png') ?>" alt="CA Logo"></div>
        </div>
        <?php if(session()->getFlashdata('success')): ?>
        <div style="color: green; padding: 10px;">
            <?= session()->getFlashdata('success'); ?>
        </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
        <div style="
    background: #fdecea;
    color: #b71c1c;
    padding: 12px 16px;
    border-radius: 8px;
    border-left: 4px solid #e53935;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
">
            ⚠️ <?= session()->getFlashdata('error'); ?>
        </div>

        <?php endif; ?>
        <form id="loginForm" action="<?= site_url('login-for-entry'); ?>" method="POST">

            <div class="form-group">
                <label for="email"> Email</label>
                <input id="email" name="email" class="input" type="text" value="<?= old('email') ?>"
                    placeholder="e.g. rajesh@gmail.com" />
                <small class="error-msg" id="email"></small>
            </div>

            <div class="form-group password-box">
                <label for="password">Password</label>
                <input id="password" class="input" name="pass" type="password" placeholder="••••••••" />
                <span class="eye-icon" id="togglePassword">🙈</span>
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
    const passwordInput = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");

    toggle.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.textContent = "👁️";
        } else {
            passwordInput.type = "password";
            this.textContent = "🙈";
        }
    });

    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('email');
    const passwordError = document.getElementById('passwordError');

    form.addEventListener('submit', function(e) {
        // prevent submit first
        e.preventDefault();

        let isValid = true;

        // reset previous errors
        email.classList.remove('input-error');
        password.classList.remove('input-error');
        emailError.textContent = '';
        passwordError.textContent = '';

        if (email.value.trim() === '') {
            email.classList.add('input-error');
            emailError.textContent = 'User ID / Email is required';
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