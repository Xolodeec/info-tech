<?php

namespace app\modules\auth\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['email', 'email'],
        ];
    }
}