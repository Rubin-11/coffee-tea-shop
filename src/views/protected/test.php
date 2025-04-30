<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Защищенная страница</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h2>Защищенная страница</h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h4>Поздравляем!</h4>
                            <p>Вы успешно получили доступ к защищенной странице. Это означает, что:</p>
                            <ul>
                                <li>Вы авторизованы в системе</li>
                                <li>AuthMiddleware работает корректно</li>
                                <li>Система маршрутизации правильно обрабатывает защищенные маршруты</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a href="/" class="btn btn-primary">На главную</a>
                            <a href="/logout" class="btn btn-danger">Выйти</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
