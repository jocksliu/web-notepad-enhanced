<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录 - 记事本</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
    <div class="main-container">
        <div class="logo">记事本</div>
        <div class="login-container">
            <?php if (isset($error)): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            <form method="post"  action="index.php">
                <div class="form-input">
                    <input type="password" id="password" name="password" placeholder="输入密码">
                </div>
                <div class="form-input">
                    <button type="submit">登录</button>
                </div>
                <div class="remember-me-container">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">保持登录7天</label>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
