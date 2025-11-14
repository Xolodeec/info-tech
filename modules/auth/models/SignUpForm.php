<?php

namespace app\modules\auth\models;

use app\modules\auth\models\User;
use yii\base\Model;

class SignUpForm extends Model
{
    public $phone;
    public $password;
    public $passwordRepeat;

    public function rules()
    {
        return [
            [['phone', 'password', 'passwordRepeat'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['phone', 'unique', 'targetClass' => User::class, 'message' => 'Этот phone уже занят.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'passwordRepeat' => 'Подтверждение пароля',
        ];
    }

    public function signUp() :bool
    {
        if ($this->validate()) {

            $user = new User();
            $user->phone = $this->phone;
            $user->setPassword($this->password);

            if ($user->save()) {
                return \Yii::$app->user->login($user, 3600 * 24 * 30);
            }
        }

        return false;
    }
}