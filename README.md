# Описание директорий и файлов Docker
- **./docker/nginx** - логи, файлы настройки **ssl**, конфигурации **nginx**.
- **./docker/mysql** - конфигурация **mysql**.
- **./back/php-fpm** - логи, конфигурации **php-fpm**.
- **./back/start.sh** - файл запуска сервиса **php-fpm**.

# Инструкция по развертыванию
- Установить **docker**, **docker-compose**.
- Склонировать репозиторий.
- Задать права доступа для всего проекта:
    - ```sudo chown -R www-data:www-data .```
    - ```sudo chmod 775 -R .```
- Скопировать файл виртуального окружения в зависимости от окружения (**.env.dev** / **.env.prod**) из корневой директории, назвав его **.env**.
- Продублировать получившийся файл **.env** в **./back**.
- Скопировать файл виртуального окружения в зависимости от окружения (**.env.dev** / **.env.prod**) из **./front**, назвав его **.env** и сохранив в той же директории.
- Убедиться что на хост-машине не заняты порты **3366, 3399, 80** каким-либо из сервисов (**apache2 / nginx / mysql**).
- Запустить сборку и запуск частей приложения в зависимости от окружения:
  - ```docker-compose -f docker-compose.dev.yml up --build -d``` (dev).
  - ```docker-compose -f docker-compose.prod.yml up --build -d``` (prod).
- Добавить привязку доменных имен **test-task.com**, **api.test-task.com** к локальному хосту в файле hosts (для dev).
- Выполнить миграции для **back** части внутри контейнера: 
  - ```docker-compose -f docker-compose.prod.yml exec php-fpm bash```
  - ```php yii migrate```

## Дополнительно
- Для тестов можно использовать дамп **database_test_task_dump.sql**, который находится в **./back**.   
Для этого необходимо прокинуть файл дампа в контейнер и выполнить импорт (пример с тестовой продуктовой базой данных):
```
docker cp ./back/database_test_task_dump.sql test-task-test-prod-mysql-1:/home/database_test_task_dump.sql
docker-compose -f docker-compose.dev.yml exec test-prod-mysql bash
mysql -h localhost -P 3306 -u root -p test_task_test_prod < ./home/database_test_task_dump.sql
```
- Таблица **products** используется для выполнения задания части **front**.
- Таблицы **customers**, **orders**, **items**, а также все связанные с ними _индексы_, _представления_, _процедуры_, _триггеры_ и _события_ являются тестовыми.

# Особенности
- Для **dev** среды добавляется развертка сервиса **test-prod-mysql** для осуществления тестирования **back** модуля (вне общей сети **app-network**).
- Для **dev** среды сервиса **php-fpm** добавляется установка и конфигурация **xdebug**.
- Сервис **react-app** для **dev** среды собирается в виде приложения на порту **3000**, а для **prod** компилируется билд, **nginx** настроен на обработку запросов соответствующим образом.