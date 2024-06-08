<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录 - 记事本</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(-45deg, #f093fb, #f5576c, #4facfe, #00f2fe, #4facfe, #f093fb);
            background-size: 600% 600%;
            animation: gradientBG 20s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .form-input {
            margin-bottom: 15px;
        }
        .form-input input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .form-input button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #5c5cff;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .form-input button:hover {
            background-color: #4a4aff;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>登录</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-input">
                <input type="password" id="password" name="password" placeholder="输入密码">
            </div>
            <div class="form-input">
                <button type="submit">登录</button>
            </div>
        </form>
    </div>
    
<div class="footer">
    <a href="https://beian.miit.gov.cn/" target="_blank">粤ICP备XXXXXX号</a>
</div>

<style>
    .footer {
        position: fixed;
        left: 0;
        bottom: 20px;
        width: 100%;
        text-align: center;
    }

    .footer a {
        color: #777;
        text-decoration: none;
        font-size: 14px;
    }

    .footer a:hover {
        text-decoration: underline;
    }
</style>
    
</body>

</html>
