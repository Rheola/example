<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 10:53
 */
class SiteController extends Controller{


    public function actionIndex(){

        $this->render('index');
    }

    public function actionError(){
        $this->render('error');
    }

    public function actionLogin(){

        if($this->user->isAuth()){
            header('Location: /review/admin', true);
        }

        include __DIR__.'/../models/LoginForm.php';

        $loginForm = new LoginForm();
        if(isset($_POST['LoginForm'])){
            $post = $_POST['LoginForm'];
            $loginForm->login = $post['login'];
            $loginForm->password = $post['password'];
            if($loginForm->validate() && $loginForm->authenticate()){
                header('Location: /review/admin', true);
            }
        }
        $this->render('login', ['loginForm' => $loginForm]);
    }

    public function actionLogout(){
        $_SESSION = [];
        session_destroy();
        header('Location: /site/login', true);
    }
}