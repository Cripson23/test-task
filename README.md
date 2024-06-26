# Описание директорий и файлов Docker
- **.env.dev** - файл виртуального окружения для среды разработки (используется соответствующим **docker-compose** и для **back** приложения).
- **.env.prod** - файл виртуального окружения для продуктовой среды (используется соответствующим **docker-compose** и для **back** приложения).
- **./docker/nginx** - логи, файлы настройки **ssl**, конфигурации **nginx**.
- **./docker/mysql** - конфигурация **mysql**.
- **./back/php-fpm** - логи, конфигурации **php-fpm**.
- **./back/start.sh** - файл запуска сервиса **php-fpm**.

# Инструкция по развертыванию
- Установить **docker**, **docker-compose**.
- Склонировать репозиторий.
- Задать права доступа для всего проекта:
    - В среде разработки:
        - ```sudo chown -R www-data:www-data .```
        - ```sudo chmod 775 -R .```
    - В продуктовой среде:
        - ```sudo chown -R www-data:www-data .```
        - ```sudo find . -type d -exec chmod 750 {} \; && sudo find . -type f -exec chmod 640 {} \;```
- Скопировать файл виртуального окружения в зависимости от окружения (**.env.dev** / **.env.prod**) из корневой директории, назвав его **.env**.
- Продублировать получившийся файл **.env** в **./back**.
- Скопировать файл виртуального окружения в зависимости от окружения (**.env.dev** / **.env.prod**) из **./front**, назвав его **.env** и сохранив в той же директории.
- Убедиться что на хост-машине не заняты порты **3366, 3399, 80** каким-либо из сервисов (**apache2 / nginx / mysql**).
- Для **prod** окружения поместить файлы ssl сертификатов в директорию **./docker/nginx/ssl**:
  - **back**: 
    - certificate_back.crt
    - private_back.key
  - **front**: 
    - certificate_front.crt
    - private_front.key
- Запустить сборку и запуск частей приложения в зависимости от окружения:
  - ```docker-compose -f docker-compose.dev.yml up --build -d``` **(dev)**.
  - ```docker-compose -f docker-compose.prod.yml up --build -d``` **(prod)**.
- Добавить привязку доменных имен **test-task.com**, **api.test-task.com** к локальному хосту в файле hosts (**для локальной развертки**).
- Выполнить миграции для **back** части внутри контейнера: 
  - ```docker-compose -f docker-compose.prod.yml exec php-fpm bash```
  - ```php yii migrate```

## Дополнительно
- Для тестов можно использовать дамп **database_test_task_dump.sql**, который находится в **./back**.   
Для этого необходимо прокинуть файл дампа в контейнер и выполнить импорт (пример с тестовой продуктовой базой данных для **dev**):
```
docker cp ./back/database_test_task_dump.sql test_task-test-prod-mysql-1:/home/database_test_task_dump.sql
docker-compose -f docker-compose.dev.yml exec test-prod-mysql bash
mysql -h localhost -P 3306 -u admin -p test_task_test_prod < ./home/database_test_task_dump.sql
```
После ввести пароль от пользователя **admin**.

- Таблица **products** используется для выполнения задания части **front**.
- Таблицы **customers**, **orders**, **items**, а также все связанные с ними _индексы_, _представления_, _процедуры_, _триггеры_ и _события_ являются фиктивными (для проверки работы модуля синхронизации баз данных).

# Особенности
- Для **dev** среды добавляется развертка сервиса **test-prod-mysql** для осуществления тестирования **back** модуля (вне общей сети **app-network**).
- Для **dev** среды сервиса **php-fpm** добавляется установка и конфигурация **xdebug**.
- Сервис **react-app** для **dev** среды собирается в виде приложения на порту **3000**, а для **prod** компилируется билд, **nginx** настроен на обработку запросов соответствующим образом.
