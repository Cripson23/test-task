# Модуль синхронизации баз данных
## Стек технологий
- PHP: **8.1**
- Веб-фреймворк: **Yii2**
- СУБД: **Mysql 8**
## Реализация
Данный модуль состоит из контроллера командной строки **DatabaseSyncModule \ commands \ DatabaseSyncController.php**, который обрабатывает команды:
- **database-sync** (вызывается действие по умолчанию **actionIndex**) непосредственно синхронизирует базы данных, принимает параметры:
    - --batchSize (-bs) - размер партии данных, который будет использоваться при синхронизации (по умолчанию **1000**).
    - --targetDb (-tdb) - строка названия компонента базы данных назначения, куда будет происходить перенос (по умолчанию **db**).
    - --sourceDb (-sdb) - строка названия компонента базы данных назначения, откуда будет происходить перенос (по умолчанию **db_prod**).
    - --noData (-nd) - флаг определяющий не переносить ли само содержимое таблиц, если передан, то данные не будут перенесены (по умолчанию **false**).
    - --noProcedures (-np) - флаг определяющий не переносить ли хранимые процедуры, если передан, то хранимые процедуры не будут перенесены (по умолчанию **false**).
    - --noTriggers (-nt) - флаг определяющий не переносить ли триггеры, если передан, то триггеры не будут перенесены (по умолчанию **false**).
    - --noViews (-nv) - флаг определяющий не переносить ли представления, если передан, то представления не будут перенесены (по умолчанию **false**).
    - --noEvents (-ne) - флаг определяющий не переносить ли события, если передан, то события не будут перенесены (по умолчанию **false**).
- **database-sync/add-cron-task** (вызывается действие actionAddCronTask) добавляет задачу на синхронизацию баз данных в Cron, принимает параметры, аналогичные команде **database-sync/index**, за исключением дополнительных:
    - --hours (-h) - число обозначающее часы для выполнения задания Cron (от 0 до 23, по умолчанию **0**)
    - --minutes (-m) - число обозначающее минуты для выполнения задания Cron (от 0 до 59, по умолчанию **0**)
    - --daysInterval (-di) - число обозначающее количество дней через которое будет повторяться выполнение задания Cron (от 1 до 30, по умолчанию **1**)
- **database-sync/remove-cron-tasks** (вызывается действие actionRemoveCronTasks) очищает задачи на синхронизацию баз данных в Cron, не принимает параметры. 

Реализована базовая модель **DatabaseSyncModule \ models \ BaseDatabaseSyncService.php** дабы переиспользовать правила валидации, события модели и т.д.   
Выполнение синхронизации реализовано в сервисной модели **DatabaseSyncModule \ models \ DatabaseSyncService.php**   
Выполнение постановки и удаления задач Cron реализовано в сервисной модели **DatabaseSyncModule \ models \ CronDatabaseSyncService.php**   
Вспомогательные функции для логирования данных выполнены в классе **DatabaseSyncModule \ Logger.php**
Работает для любых компонентов баз данных Yii2, задаваемых параметрами.

### Настройки подключения к базам данных
- Все параметры подключения к базам данных должны находиться в файле **.env**, в корневой директории.
- Дамп базы данных для тестов находится в корне проекта **database_test_task_dump.sql**
- Для корректного использования модуля необходимо убедиться, что у пользователя баз данных есть соответствующие права для работы с методами БД синхронизируемых разделов.   
Например, если в определении триггеров присутствует **DEFINER**, то для их успешного переноса компоненты БД должны осуществлять подключение под этим пользователем   
(в тестовом дампе в качестве **DEFINER** используется **admin**).

### Cron
- Cron запускается, используется и выполняет команды от пользователя **root**
- В командах для интерпретатора php используется путь по умолчанию **/usr/local/bin/php**

### Products
- Реализовано одно действие для отдачи данных о товарах **ProductsController/index** с использованием **models/Product.php** и **models/ProductSearch.php** (фильтрация, пагинация, сортировка) для front приложения.
```
{
    "filter": {"title": "Reebok"},
    "sort": {"price": "ASC"},
    "pagination": {"page": 1, "per-page": 15}
}
```
- Все товары представленные в дампе имеют одинаковую картинку (заглушку), но используют разные файлы.

## Пример использования команд
Запускать команды следует из корневой директории приложения Yii2, внутри контейнера php-fpm (**dev**)
```
docker-compose -f docker-compose.dev.yml exec php-fpm bash
```
### Запуск синхронизации
Пример варианта использования команды с полным наименованием параметров.
```
./yii database-sync-module/database-sync --batchSize=1000 --targetDb=db --sourceDb=db_prod --noData --noProcedures --noTriggers --noViews --noEvents
```
Пример варианта использования команды с кратким наименованием параметров.
```
./yii database-sync-module/database-sync -bs=5 -tdb=db -sdb=db_prod -nd -np -nt -nv -ne
```
### Добавление задачи в Cron
Пример варианта использования команды с полным наименованием параметров (синхронизация только структуры таблиц, каждые 3 дня в 02:59).
```
./yii database-sync-module/database-sync/add-cron-task --batchSize=1000 --targetDb=db --sourceDb=db_prod --noData=asdasd --noProcedures --noTriggers --noViews --noEvents --hours=2 --minutes=59 --daysInterval=3
```
Пример варианта использования команды с кратким наименованием параметров (полная синхронизация, каждый день в 01:00).
```
./yii database-sync-module/database-sync/add-cron-task -bs=5 -tdb=db -sdb=db_prod -h=1 -m=0 di=1
```
### Удаление задач из Cron
```
./yii database-sync-module/database-sync/remove-cron-tasks
```