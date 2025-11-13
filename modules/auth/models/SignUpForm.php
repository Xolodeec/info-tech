<?php

namespace app\modules\auth\models;

use yii\base\Model;

class SignUpForm extends Model
{
    public $email;
    public $password;
    public $passwordRepeat;

    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['email', 'email'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
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
}