<?php

/* @var $this yii\web\View */
/* @var $reg app\models\RegForm */
/* @var $forget app\models\PasswordResetForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Заголовок главной страницы';
?>
<div class="site-index row">

    <?= $this->render("_pass", ['model' => $forget]); ?>
    <?= $this->render("_reg", ['model' => $reg]); ?>

    <div class="col-sm-6">
        <h1 class="title">Название приложения</h1>
        <h2  class="title">Краткое описание приложения</h2>
    </div>
    <div class="col-sm-6 login-form">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template'=>"{input}\n{hint}\n{error}"
            ]
        ]); ?>

        <div class="rgt-panel">
            <?= $form->field($model, 'email')->textInput([
                    'maxlength' => true,
                    'placeholder'=>$model->getAttributeLabel('email')
                ]); ?>

            <?= $form->field($model, 'password')->passwordInput([
                    'maxlength' => true,
                    'placeholder'=>$model->getAttributeLabel('password')
                ]);
            ?>
        </div>

        <div class="clr">

        <div class="form-group">
            <?= Html::button('<i class="glyphicon glyphicon-user"></i> Регистрация', [
                'class' => 'btn btn-lg btn-primary',
                'data-toggle' => 'modal',
                'data-target' => '#reg',
                'name' => 'login-button'
            ]) ?>
            <?= Html::submitButton('<i class="glyphicon glyphicon-play"></i> Войти', [
                'class' => 'btn btn-lg btn-primary',
                'name' => 'login-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="hint-block">
            Регистрировались, но <?=Html::a('забыли пароль', ['#'], [
                'class' => 'lnk',
                'data-toggle' => 'modal',
                'data-target' => '#pass',
            ])?>?
        </div>

    </div>
</div>
