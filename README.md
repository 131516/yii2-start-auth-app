Yii2-start-auth-app
===================

Шаблон приложения с организованными возможностями:

* авторизации
* регистрации (с подтверждением Email)
* восстановление пароля (через Email)

на главной странице в виде модальных окон.

Установка
---------

```
composer create-project shekhovtsovy/yii2-start-auth-app project-name
```

В файле config/db.php устанавливаем настройки соединения с базой данных:

```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

```

Запускаем миграции:

```
php yii migrate
```



