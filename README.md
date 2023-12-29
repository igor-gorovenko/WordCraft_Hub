# Word craft hub

Площадка, которая позволяет определить список необходимых слов по категориям и скачать их в формате таблицы. 

## Функции

- Список слов
- Фильтр слов по категориям
- Возможность скачать таблицу с выбранными словами

## Getting Started

#### 1. Clone this repository:

Скопировать проект себе

```
git clone git@github.com:igor-gorovenko/word_craft_hub.git
```

Переходим в скопированный проект, в корневую папку

```
cd word_craft_hub
```

#### 2. Install dependencies:

Устанавливаем composer

```
composer install
```

Копируем .env.example и меняем имя: .env

Генерируем APP_KEY в .env файле

```
php artisan key:generate
```

Устанавливаем npm и делаем сборку проекта
```
npm install
npm run build
```

Выполняем миграции

```
php artisan migrate
```

#### 3. Generate data

Генерируем данные
```
php artisan db:seed
```

#### 4. Запускаем проект

Запустить сервер с помощью artisan или своим способом
```
php artisan serve
```

Пользователи для входа
```
// Admin

admin@example.com
test1234

// User

user@example.com
test1234
```