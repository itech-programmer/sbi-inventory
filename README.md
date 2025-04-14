# SBI Inventory

Простой модуль учёта товаров на Laravel 10 с архитектурой Service + Repository, поддержкой API, Excel-экспорта и очередей.

---

## ✅ Соответствие техническому заданию SBI

| №  | Пункт ТЗ                                          | Реализация                                                                |
|----|---------------------------------------------------|---------------------------------------------------------------------------|
| 1  | Сущности "Категория" и "Товар"                    | Модели + миграции + связи в `app/Models`                                  |
| 2  | Инициализация 3 категорий и 200 товаров           | Сидеры `CategorySeeder`, `ProductSeeder` + `ProductFactory`               |
| 3  | API для товаров и категорий                       | `ProductController`, `CategoryController`, маршруты в `routes/api/v1.php` |
| 4  | Валидация данных                                  | `StoreProductRequest`, `UpdateProductRequest`, формат EAN-13              |
| 5  | Представление через Laravel API Resources         | `ProductResource`, `CategoryResource`, с использованием `whenLoaded()`    |
| 6  | Unit-тестирование                                 | `ProductServiceTest`, `ExportProductsJobTest`, покрытие всех сценариев    |
| 7  | Выгрузка в Excel через очередь                    | `ProductsExport`, `ExportProductsJob`, очередь `queue:work`, `storage/`   |
| 8  | GIT + README                                       | Публичный репозиторий + этот файл `README.md`                             |
| 9  | SOLID и DI                                         | `ProductServiceInterface`, `ProductRepositoryInterface` + DI в сервисе    |
| 10 | Laravel 10+                                        | Используется Laravel 10                                                   |
| 11 | Видео-презентация                                 | -                                                                         |

---

## 📊 Примеры работы API

### 📁 Категории

#### ✅ GET /api/v1/categories

Цель: список всех категорий

Пример ответа:

```json
  [
    { "id": 1, "name": "Смартфоны" },
    { "id": 2, "name": "Зарядки" },
    { "id": 3, "name": "Чехлы" }
  ]
```

#### ✅ POST /api/v1/categories

Цель: создание новой категории

Пример запроса:

```json
    { "name": "Аксессуары" }
```

Пример ответа:

```json
    { "id": 4, "name": "Аксессуары" }
```

#### ✅ GET /api/v1/categories/{id}

Цель: получить одну категорию

Пример ответа:

```json
    { "id": 1, "name": "Смартфоны" }
```

#### ✅ PUT /api/v1/categories/{id}

Цель: обновить категорию

Пример запроса:

```json
    { "name": "Планшеты" }
```

Пример ответа:

```json
    { "id": 1, "name": "Планшеты" }
```

#### ✅ DELETE /api/v1/categories/{id}

Цель: удаление категории

Пример ответа:
(No content)

### 📦 Товары

#### ✅ GET /api/v1/products

Цель: список всех товаров

Пример ответа:

```json
  [
    {
      "id": 1,
      "name": "iPhone 13",
      "price": "1299.99",
      "barcode": "1234567890123",
      "category": "Смартфоны"
    },
    {
      "id": 2,
      "name": "Зарядка Type-C",
      "price": "19.99",
      "barcode": "9876543210987",
      "category": "Зарядки"
    }
  ]
```

#### ✅ POST /api/v1/products

Цель: создать новый товар

Пример запроса:

```json
    {
      "name": "iPad Mini",
      "price": 499.99,
      "barcode": "1231231231231",
      "category_id": 1
    }

```

Пример ответа:

```json
    {
      "id": 3,
      "name": "iPad Mini",
      "price": "499.99",
      "barcode": "1231231231231",
      "category": "Смартфоны"
    }
```

#### ✅ GET /api/v1/products/{id}

Цель: получить один товар

Пример ответа:

```json
    {
      "id": 3,
      "name": "iPad Mini",
      "price": "499.99",
      "barcode": "1231231231231",
      "category": "Смартфоны"
    }
```

#### ✅ PUT /api/v1/products/{id}

Цель: обновить товар

Пример запроса:

```json
    { "price": 449.99 }
```

Пример ответа:

```json
    {
      "id": 3,
      "name": "iPad Mini",
      "price": "449.99",
      "barcode": "1231231231231",
      "category": "Смартфоны"
    }
```

#### ✅ DELETE /api/v1/products/{id}

Цель: удалить товар

Пример ответа:
(No content)

#### ✅ POST /api/v1/products/export

Цель: экспорт всех товаров в Excel-файл через очередь

Пример ответа:

```json
    {
      "status": "Export queued"
    }
```

## 📁 Результирующий файл будет доступен в storage/app/exports/products_YYYYMMDD_HHMMSS.xlsx

### ❌ Примеры невалидных запросов

#### 🟥 POST /api/v1/products — неверный EAN-13

Пример запроса:

```json
    {
      "name": "Неправильный товар",
      "price": 99.99,
      "barcode": "12345",
      "category_id": 1
    }
```

Пример ответа:

```json
    {
      "message": "The barcode format is invalid.",
        "errors": {
          "barcode": [
            "Штрихкод должен соответствовать формату EAN-13 (13 цифр)"
          ]
        }
    }
```

#### 🟥 POST /api/v1/products — отсутствие обязательного поля

Пример запроса:

```json
    {
      "price": 199.99,
      "barcode": "1234567890123",
      "category_id": 1
    }
```

Пример ответа:

```json
    {
      "message": "The given data was invalid.",
      "errors": {
          "name": [
            "Поле name обязательно для заполнения."
          ]
      }
    }
```

## 🧱 Архитектура проекта

- Контроллеры: минимальная логика, делегируют в сервис
- Сервисы: бизнес-логика (ProductService, CategoryService)
- Репозитории: взаимодействие с Eloquent (ProductRepository)
- DI: интерфейсы и привязка в AppServiceProvider
- Формы: FormRequest с валидацией и логикой EAN-13
- API Resource: форматированный вывод с использованием whenLoaded()
- Очередь: ExportProductsJob + php artisan queue:work
- Экспорт: ProductsExport на базе maatwebsite/excel
- Проект построен с соблюдением принципов SOLID, гибкой архитектуры и возможностью масштабирования.

---

## 📦 Возможности

- CRUD для товаров и категорий
- Валидация через FormRequest
- Структура по SOLID-принципам (Service / Repository)
- Выгрузка товаров в Excel через очередь
- Unit-тесты всех сценариев
- Полноценное Docker-окружение

---

## 🚀 Установка

```bash
    git clone https://github.com/itech-programmer/sbi-inventory.git
    cd sbi-inventory
```

```    
    make start
```

---

## 🌐 Доступ к сервисам

- Laravel: [http://localhost:9000](http://localhost:9000) 
- pgAdmin: [http://localhost:8080](http://localhost:8080)
    - Email: `admin@example.com`
    - Пароль: `admin`
    - Хост: `db`, порт: `5432`
- Redis: доступ по `localhost:6379` (автоматически используется Laravel)

---

## 🛠 Makefile команды

| Команда                | Описание                                              |
|------------------------|-------------------------------------------------------|
| `make start`           | Установка, запуск контейнеров, установка зависимостей |
| `make up`              | Запуск Docker-контейнеров                             |
| `make down`            | Остановка Docker-контейнеров                          |
| `make restart`         | Перезапуск                                            |
| `make build`           | Пересборка без кэша                                   |
| `make migrate`         | Миграции                                              |
| `make seed`            | Выполнение сидеров                                    |
| `make fresh`           | `migrate:fresh --seed`                                |
| `make test`            | Запуск юнит-тестов                                    |
| `make queue`           | Запуск очереди                                        |
| `make bash`            | Войти в контейнер Laravel                             |
| `make logs`            | Просмотр логов всех контейнеров                       |
| `make optimize`        | Кеширование конфига/маршрутов/представлений           |
| `make cache-clear`     | Очистка кэша конфигов/маршрутов/представлений         |
