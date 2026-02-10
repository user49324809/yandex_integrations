# Yandex Maps Integration

Тестовое задание.

## Стек
- Laravel 12
- Vue 3
- Inertia
- MySQL

## Функционал
- Авторизация (регистрация / логин)
- Страница настроек интеграции
- Сохранение ссылки на Яндекс
- Получение company_id из ссылки
- Вывод рейтинга компании
- Вывод списка отзывов

## Установка

1. Клонировать репозиторий:
   git clone https://github.com/user49324809/yandex_integrations.git

2. Установить зависимости:
   composer install
   npm install

3. Создать .env и настроить БД (MySQL)

4. Выполнить миграции:
   php artisan migrate

5. Запустить проект:
   npm run dev
   php artisan serve

## Доступ
Регистрация доступна по адресу /register
