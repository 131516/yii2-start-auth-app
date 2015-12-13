<?php
/**
 * Created by PhpStorm.
 * User: YunX
 * Date: 11.12.2015
 * Time: 16:19
 */

namespace app\models;

use Yii;

/**
 * RegForm is the model behind the login form.
 */
class RegForm extends User
{
    public $password;
    public $captcha;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'password', 'email', 'captcha'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(),
                'message' => 'Данный Email уже зарегистрирован.'],
            ['captcha', 'captcha','captchaAction'=>'site/captcha'],
            [['password'], 'string', 'min' => 4],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            [['name', 'email'], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'email' => 'Email',
            'name' => 'Имя',
            'captcha' => 'Код с картинки'
        ];
    }

    /**
     * @param bool $insert
     * @param $changedAttributes
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
            $this->generateEmailConfirmToken();
            return true;
        }
        return false;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->mailer->compose('confirmEmail', ['model' => $this])
            ->setFrom([Yii::$app->params['adminEmail']])
            ->setTo($this->email)
            ->setSubject('Подтверждение регистрации на сайте')
            ->send();
    }
}
