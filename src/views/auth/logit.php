<!DOCTYPE html>
<html>

<head>
    <title>Вход</title>
</head>

<body>
    <a href="/">Главная</a>
    <h1>Вход</h1>
    <form action="/login" method="post">
        <?php if (!empty($errors)): ?>
            <div style="color: red;"><?= htmlspecialchars($errors); ?></div>
        <?php endif; ?>
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Войти</button>
    </form>
</body>

</html>