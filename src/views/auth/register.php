<!DOCTYPE html>
<html>

<head>
    <title>Регистрация</title>
</head>

<body>
    <h1>Регистрация</h1>
    <a href="/">Главная</a>
    <form action="/register" method="post">
        <?php if (!empty($errors)): ?>
            <div style="color: red;"><?= htmlspecialchars($errors); ?></div>
        <?php endif; ?>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="password" name="password" placeholder="Пароль"><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <a href="/login">Уже есть аккаунт? Войти</a>
</body>

</html>