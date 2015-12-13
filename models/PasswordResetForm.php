<?php
namespace app\models;

use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetForm extends Model
{
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'password'], 'required'],
            [['password'], 'string', 'min' => 4],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Пользователь с таким Email не зарегистрирован.'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'email' => 'Email',
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user =  User::find()->where([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ])->one();

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }
            if ($user->save()) {
                return \Yii::$app->mailer->compose('passwordResetToken', [
                    'model' => $user,
                    'password' => $this->password
                ])
                    ->setFrom(\Yii::$app->params['adminEmail'])
                    ->setTo($this->email)
                    ->setSubject('Сброс пароля на сайте')
                    ->send();
            }
        }

        return false;
    }
}
