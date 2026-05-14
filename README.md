# PHP Generators Micro Project

Мини-проект показывает практическое применение генераторов в PHP: потоковая обработка CSV-файла с заказами без загрузки всего файла в память.

## Сценарий

Есть файл `data/orders.csv` с заказами интернет-магазина. Скрипт:

1. Лениво читает CSV построчно через `yield`.
2. Преобразует строки в массивы с типизированными значениями.
3. Лениво фильтрует оплаченные заказы.
4. Считает выручку по категориям.

Генераторы полезны здесь потому, что такой же код будет работать и для файла на 10 строк, и для файла на миллионы строк: в памяти находится только текущая строка.

## Запуск

```bash
php bin/report.php
```

Можно передать свой CSV-файл:

```bash
php bin/report.php path/to/orders.csv
```

## Запуск через Docker

Сборка образа:

```bash
docker build -t php-generators-demo .
```

Запуск:

```bash
docker run --rm php-generators-demo
```

Запуск через Docker Compose:

```bash
docker compose up --build
```

Если нужно подменить `data/orders.csv`, положите новый файл в локальную папку `data/` и запустите:

```bash
docker compose run --rm app php bin/report.php data/orders.csv
```

## Формат CSV

```csv
id,date,customer,category,amount,status
1001,2026-04-01,Alice,books,24.90,paid
```

Обязательные статусы для примера:

- `paid` - заказ учитывается в отчете.
- `pending`, `refunded`, `cancelled` - заказ пропускается.

## Где смотреть генераторы

- `src/OrderStream.php` - чтение CSV через `yield`.
- `src/Report.php` - ленивый фильтр `paidOrders()` и агрегация.
- `bin/report.php` - CLI-точка входа.
