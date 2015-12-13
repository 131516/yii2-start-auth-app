<?php

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $password string */


use yii\helpers\Html;

if (isset($model) && $model) {
    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['reset',
        'token' => $model->password_reset_token,
        'password' => $password]);
?>

<p>Здравствуйте, <?= Html::encode($model->name) ?>!</p>

<p>Сформирован запрос на установку следующего пароля
    на сайте: <b><?= Html::encode($password) ?></b>.</p>

<p>Для его активации и авторизации по новому
    паролю проследуйте по ссылке:

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>.
</p>

<p>Если Вы не подавали запрос на изменение пароля,
    то ни в коем случае не переходите по ссылке и
    просто удалите письмо.</p>
<?php
}
?>
