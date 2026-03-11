<?php
session_start();
require_once '../includes/config.php';

// Обработка входа
if (isset($_POST['login'])) {
    if ($_POST['user'] == 'admin' && $_POST['pass'] == 'kiirprint2026') {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit; // Важно добавлять exit после редиректа
    } else {
        $error = "Vale kasutajatunnus või parool!";
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiirprint | Halduspaneel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --main-orange: #f36f21;
            --main-orange-hover: #d95d16;
            --text-dark: #2d3748;
            --text-muted: #718096;
            --bg-color: #f8fafc;
            --border-color: #e2e8f0;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--bg-color);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            box-sizing: border-box;
        }
        
        .login-card {
            background: #ffffff;
            padding: 45px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            border: 1px solid var(--border-color);
            text-align: center;
        }
        
        .logo-text {
            font-size: 32px;
            font-weight: 900;
            color: var(--main-orange);
            letter-spacing: 1.5px;
            margin-bottom: 5px;
        }
        
        .subtitle {
            color: var(--text-muted);
            font-size: 15px;
            margin-bottom: 35px;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
            text-align: left;
        }
        
        /* Иконки внутри полей ввода */
        .form-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 18px;
            color: #a0aec0;
            font-size: 16px;
            transition: 0.2s;
        }
        
        .form-group input {
            width: 100%;
            padding: 16px 15px 16px 50px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 15px;
            background: #f8fafc;
            transition: 0.2s;
            box-sizing: border-box;
            color: var(--text-dark);
            font-weight: 600;
        }
        
        /* Эффект при клике на поле */
        .form-group input:focus {
            border-color: var(--main-orange);
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(243, 111, 33, 0.15);
        }
        .form-group input:focus + i, .form-group input:focus ~ i {
            color: var(--main-orange);
        }
        
        .btn-login {
            width: 100%;
            background: var(--main-orange);
            color: white;
            border: none;
            padding: 16px;
            font-weight: 800;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
            box-shadow: 0 4px 10px rgba(243, 111, 33, 0.2);
        }
        
        .btn-login:hover {
            background: var(--main-orange-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(243, 111, 33, 0.3);
        }
        
        .alert-error {
            background: #fff5f5;
            color: #c53030;
            padding: 14px 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            border: 1px solid #fed7d7;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            text-align: left;
            animation: shake 0.5s ease-in-out;
        }

        /* Небольшая анимация тряски при ошибке */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <div class="logo-text">KIIRPRINT</div>
        <div class="subtitle">Halduspaneeli sisselogimine</div>

        <?php if(isset($error)): ?>
            <div class="alert-error"><i class="fas fa-exclamation-triangle"></i> <?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="user" placeholder="Kasutajatunnus" required autocomplete="off">
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group">
                <input type="password" name="pass" placeholder="Parool" required>
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit" name="login" class="btn-login">Logi sisse</button>
        </form>
    </div>
</div>

</body>
</html>