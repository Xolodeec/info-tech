<?php

namespace app\modules\auth\models;

use app\modules\auth\models\User;
use yii\base\Model;

class SignUpForm extends Model
{
    public $email;
    public $password;
    public $passwordRepeat;

    public function rules()
    {
        return [
            [['email', 'password', 'passwordRepeat'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['email', 'email'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email уже занят.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'passwordRepeat' => 'Подтверждение пароля',
        ];
    }

    public function signUp() :bool
    {
        if ($this->validate()) {

            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);

            if ($user->save()) {
                return \Yii::$app->user->login($user, 3600 * 24 * 30);
            }
        }

        return false;
    }
}