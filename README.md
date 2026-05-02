# 🤖 AiKraken — Telegram AI‑бот

**AiKraken** — это асинхронный Telegram‑бот, который использует современную AI‑модель для ответов на вопросы пользователей.  
Проект построен на **Symfony** с соблюдением принципов **чистой архитектуры**, **DDD** и **CQRS**.  
Обработка сообщений вынесена в очереди (**RabbitMQ**), состояние хранится в **PostgreSQL** и **Redis**.

---

## 🧱 Стек технологий

- PHP 8.4
- Symfony 8.0
- PostgreSQL 16
- RabbitMQ 4.0
- Redis 8.4
- Nginx
- Docker / Docker Compose
- GitHub Models API (openai/gpt-4.1)
- Telegram Bot API

---

## 🚀 Быстрый старт

### 1. Клонируйте репозиторий

```bash
git clone git@github.com:airo-nt/ai-kraken.git
cd ai-kraken
```

### 2. Заполните переменные .env для файла docker-compose

### 3. Заполните переменные symfony/.env.local из файла symfony/.env

```bash
cd symfony
touch .env.local
```

### 4. Локально в hosts укажите server_name из файла docker/nginx/default.conf

### 5. Из корня папки разверните docker

```bash
docker-compose up -d
```

### 6. Установите зависимости composer

```bash
docker exec -it ai-kraken-php composer install
```

### 7. Выполните миграцию

```bash
docker exec -it ai-kraken-php php bin/console doctrine:migrations:migrate
```

---

## ▶️ Запуск обработки сообщений

### 1. Запуск long polling изменений из бота

```bash
docker exec -it ai-kraken-php php bin/console app:bot_telegram:poll
```

Механизм long polling был выбран вместо webhook для удобства работы в локальной среде. В продакшен среде можно легко расширить до webhook.

### 2. Асинхронная обработка сообщений

```bash
docker exec -it ai-kraken-php php bin/console messenger:consume bot_updates_async
```

Количество воркеров можно масштабировать в зависимости от нагрузки

### 3. Обработка упавших сообщений

```bash
docker exec -it ai-kraken-php php bin/console messenger:consume failed
```

---

## 📡 API Endpoints

### Для доступа к API требуется заголовок X-API-TOKEN со значением из переменной окружения symfony/.env

Для примера был создан 1 endpoint со списком чатов GET /api/chats/, с возможными параметрами page/limit