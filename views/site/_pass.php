<?php
/**
 * Created by PhpStorm.
 * User: YunX
 * Date: 11.12.2015
 * Time: 16:14
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

Modal::begin([
    'header' => '<h2 class="title text-center">Восстановление пароля</h2>',
    'toggleButton' => false,
    'id' => 'pass'
]);

if (Yii::$app->session->hasFlash('forget-send')) {
    echo "<div class='alert alert-success text-center'>
            На Email отправлено сообщение с ссылкой активации
            нового пароля и автоматической авторизации по нему.
          </div>";
} else {
    $form = ActiveForm::begin([
        'id' => 'pass-form',
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ],
    ]);

    echo $form->field($model, 'email')->textInput([
        'maxlength' => true,
        'placeholder' => $model->getAttributeLabel('email')
    ]);

    echo $form->field($model, 'password')->passwordInput([
        'maxlength' => true,
        'placeholder' => $model->getAttributeLabel('password')
    ]);

    echo Html::submitButton('<i class="glyphicon glyphicon-refresh"></i>
        Сбросить пароль', [
        'class' => 'text-center btn btn-lg btn-primary',
        'name' => 'pass-button'
    ]);
    ActiveForm::end();
}
Modal::end();

if (Yii::$app->session->hasFlash('forget-send')|| $model->hasErrors()) {
    $this->registerJs('$("#pass").modal("show")');
}
