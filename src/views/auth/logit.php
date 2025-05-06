<!DOCTYPE html>
<html>

<head>
    <title>Вход</title>
</head>

<body>
    <a href="/">Главная</a>
    <h1>Вход</h1>
    
    <!-- Вывод flash-сообщений -->
    <?php if (!empty($flashMessages)): ?>
        <?php foreach ($flashMessages as $type => $message): ?>
            <div style="color: <?= $type === 'success' ? 'green' : 'red' ?>;">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <form action="/login" method="post">
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
        
        <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($formData['email'] ?? ''); ?>">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Войти</button>
    </form>
    <a href="/register">Нет аккаунта? Зарегистрироваться</a>
</body>

</html>