<!DOCTYPE html>
<html>

<head>
    <title>Регистрация</title>
</head>

<body>
    <h1>Регистрация</h1>
    <a href="/">Главная</a>
    
    <!-- Вывод flash-сообщений -->
    <?php if (!empty($flashMessages)): ?>
        <?php foreach ($flashMessages as $type => $message): ?>
            <div style="color: <?= $type === 'success' ? 'green' : 'red' ?>;">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <form action="/register" method="post">
        <!-- CSRF-защита -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
        
        <!-- Вывод ошибок -->
        <?php if (!empty($errors)): ?>
            <div style="color: red;">
                <?php foreach ($errors as $field => $message): ?>
                    <div><?= htmlspecialchars($message); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($formData['email'] ?? ''); ?>"><br>
        <input type="password" name="password" placeholder="Пароль"><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <a href="/login">Уже есть аккаунт? Войти</a>
</body>

</html>