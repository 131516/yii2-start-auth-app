<?php

namespace app\controllers;

use app\models\PasswordResetForm;
use app\models\RegForm;
use app\models\ResetPassword;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\EmailConfirm;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;

class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'foreColor' => '3373751' //синий
            ],
        ];
    }

    /**
     * Вывод главной страницы с 3 формами:
     * авторизация, регистрация и восстановление
     * пароля. Все 3 обработчика форм
     * лаконичнее располагать по одному
     * запросу
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            //Авторизация
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            //Регистрация
            $reg = new RegForm();
            if ($reg->load(Yii::$app->request->post()) && $reg->save()) {
                Yii::$app->getSession()->setFlash('reg-success');
                return $this->goBack();
            }
            //Восстановление пароля
            $forget = new PasswordResetForm();
            if ($forget->load(Yii::$app->request->post()) && $forget->validate()) {
                if ($forget->sendEmail()) {
                    Yii::$app->getSession()->setFlash('forget-send');
                }
                return $this->goBack();
            }

            return $this->render('index', [
                'model' => $model,
                'reg' => $reg,
                'forget' => $forget
            ]);
        } else {
            return $this->render('panel');
        }
    }

    /**
     * Выход из авторизированного
     * режима
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Подтверждение аккаунта с помощью
     * электронной почты
     *
     * @param $token
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionConfirm($token)
    {
        try {
            $model = new EmailConfirm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user_id = $model->confirmEmail()) {
            Yii::$app->user->login(User::findIdentity($user_id));
        }

        return $this->redirect(['/']);
    }

    /**
     * Сброс пароля через электронную
     * почту
     *
     * @param $token
     * @param $password
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionReset($token, $password)
    {
        try {
            $model = new ResetPassword($token, $password);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user_id = $model->resetPassword()) {
            Yii::$app->user->login(User::findIdentity($user_id));
        }

        return $this->redirect(['/']);
    }
}
