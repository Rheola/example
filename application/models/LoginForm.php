<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 01.09.16
 * Time: 12:48
 */
class LoginForm extends Model{
    public $login;
    public $password;

    private $users = [
        // username => password
        'demo' => 'demo',
        'admin' => '123',
    ];

    public function validate(){
        if(strlen($this->login) == 0){
            $this->addError('Заполните поле Логин');
        }
        if(strlen($this->password) == 0){
            $this->addError('Заполните поле Пароль');
        }

        return !$this->hasErrors();
    }

    public function authenticate(){
        $this->login = strtolower($this->login);

        if(!isset($this->users[$this->login])){
            $this->addError('Пользователь не найден');

            return false;

        } elseif($this->users[$this->login] !== $this->password){
            $this->addError('Неверный пароль');

            return false;
        }
        $_SESSION['is_auth'] = true;
        $_SESSION['user'] = $this->login;

        return true;
    }
}