<?php

/* @var $this yii\web\View */
/* @var $model app\models\User */

use yii\helpers\Html;

if (isset($model) && $model) {
    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['confirm', 'token' => $model->email_confirm_token]);
?>

<p>Здравствуйте, <?= Html::encode($model->name) ?>!</p>

<p>Для подтверждения адреса и первичной
    авторизации пройдите по ссылке:

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>.</p>

<p>Если Вы не регистрировались у на нашем сайте,
    то просто удалите это письмо.</p>

<?php
}
?>