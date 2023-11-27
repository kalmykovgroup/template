<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * LoginForm model
 *
 * @property-read User|null $_user
 ** @property string $login
 * @property string $password
 * @property bool $rememberMe
 */


class LoginForm extends Model
{
    public string $login = "";
    public string $password = "";
    public bool $rememberMe = true;
    private null|User|ActiveRecord $_user = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {

        //Добавляем общие правила валидации
         return[

            [['login', 'password'], 'required' , 'message' => Yii::t('app', "{attribute} не может быть пустым!")],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],

        ];

    }


    /**
     * @throws Exception
     */
    public function validatePassword(): void
    {
        $user = $this->getUser("login", $this->login);

        if($user == null || !$this->_user->validatePassword($this->password)) {
            $this->addError('login');
            $this->addError('password');
        }

    }

    /**
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->_user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }


    /**
     * @throws Exception
     */
    public function getUser($field, $value): User|array|ActiveRecord|null
    {
        if (!$this->_user) {
             $this->_user = User::findByUsername([$field => $value]);
        }

        $this->_user?->checkStatusUser();

        return $this->_user;

    }
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}
