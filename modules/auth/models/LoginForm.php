<?php

namespace app\modules\auth\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $phone;
    public $password;

    private $_user = false;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['password', 'validatePassword'],
        ];
    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = User::findByPhone($this->phone);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный email или пароль.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
        }

        return false;
    }
}