# WebDevCompany

## Запуск

Для запуска проекта на компьютере должен быть установлен [Docker](https://www.docker.com/) и [docker-compose](https://docs.docker.com/compose/install/), выполните следующие команды из корневой директории проекта:

```bash
# Сборка и запуск контейнеров

docker-compose build up -d --build

# Только для Linux
# Передача прав от root пользователя локальному пользователю для доступа к папкам с проектом и базы данных

sudo chown $USER:$USER db src

# Установка пакетов composer

docker-compose run --rm composer install

# Установка пакетов NPM

docker-compose run --rm npm install

# Сборка CSS и JS файлов

docker-compose run --rm npm run dev 
```

### Порты

После выполнения вышеописанных команд сервисы будут доступны по следующим портам:
```
8000:apache
3601:mariadb
```
Соответственно, для того чтобы попать на главную страницу проекта перейдите по адресу http://localhost:8000/, а для получения доступа к базе данных воспользуйтесь любым средством администрирования баз данных, к примеру [DBeaver](https://dbeaver.io/).

### Выполнение PHP

Для выполнения php команд необходимо войти в контейнер и выполнять команды внутри него:
```
#Вход в контейнер
docker-compose exec web bash

#Выполнение миграции
php artisan migrate

#Выход из контейнера
exit
```