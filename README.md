# coffee-tea-shop 🛒☕🍵

Интернет-магазин по продаже кофе и чая с использованием современных технологий.

## 📦 Технологии

- **Backend**: PHP 8.4 (без фреймворков)
- **Database**: PostgreSQL 17
- **Web Server**: Nginx
- **Контейнеризация**: Docker + Docker Compose
- **Миграции**: Phinx

## 🚀 Быстрый старт

### Предварительные требования

- Docker >= 20.10
- Docker Compose >= 2.0
- PHP 8.4+ (опционально)

### Установка

1. Клонируйте репозиторий:
```bash
git clone https://github.com/Rubin-11/coffee-tea-shop.git
cd coffee-tea-shop
```

2. Создайте файл окружения:
```bash
cp .env.example .env
```

3. Запустите контейнеры:
```bash
docker compose up -d --build
```

4. Установите зависимости:
```bash
docker compose exec php composer install
```

5. Примените миграции и сиды:
```bash
docker compose exec php composer migrate
docker compose exec php composer seed
```

### Доступы

- **Приложение**: http://localhost
- **База данных**: 
  - Host: `localhost`
  - Port: `5432`
  - Database: `shop`
  - User: `admin` (измените в `.env`)
  - Password: `secret` (измените в `.env`)


## 🔄 Управление миграциями

- Применить миграции:
```bash
docker compose exec php composer migrate
```

- Откатить последнюю миграцию:
```bash
docker compose exec php composer migrate:rollback
```

- Запустить сидинг данных:
```bash
docker compose exec php composer seed

**Сергей Мишарин**  
📧 Email: misharin_sergey-work@mail.ru
💼 GitHub: https://github.com/Rubin-11