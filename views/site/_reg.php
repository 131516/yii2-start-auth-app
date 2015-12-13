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
use yii\captcha\Captcha;

Modal::begin([
    'header' => '<h2 class="title text-center">Регистрация</h2>',
    'toggleButton' => false,
    'id' => 'reg'
]);

if (Yii::$app->session->hasFlash('reg-success')) {
    echo "<div class='alert alert-success text-center'>
            Для активации аккаунта и первичной
            авторизации перейдите по ссылке, отправленной на Email.
          </div>";
} else {
    $form = ActiveForm::begin([
        'id' => 'reg-form',
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ],
    ]);

    echo $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'placeholder' => $model->getAttributeLabel('name')
    ]);

    echo $form->field($model, 'email')->textInput([
        'maxlength' => true,
        'placeholder' => $model->getAttributeLabel('email')
    ]);

    echo $form->field($model, 'password')->passwordInput([
        'maxlength' => true,
        'placeholder' => $model->getAttributeLabel('password')
    ]);

    echo $form->field($model, 'captcha')->widget(Captcha::className(), [
        'captchaAction' => 'site/captcha',
        'options' => [
            'placeholder' => $model->getAttributeLabel('captcha'),
            'class' => 'form-control'
        ],
        'template' => '<div class="row">
                <div class="col-lg-12">{image}</div>
                <div class="col-lg-12">{input}</div>
                </div>',
    ]);

    echo Html::submitButton('<i class="glyphicon glyphicon-ok"></i>
        Зарегистирировать', [
        'class' => 'btn btn-lg btn-primary text-center',
        'name' => 'reg-button'
    ]);

    ActiveForm::end();
}
Modal::end();

if (Yii::$app->session->hasFlash('reg-success')|| $model->hasErrors()) {
    $this->registerJs('$("#reg").modal("show")');
}
