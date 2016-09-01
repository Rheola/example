<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 22:11
 */
class WebUser{

    public function isAuth(){
        if(isset($_SESSION['is_auth'])){
            return $_SESSION['is_auth'];
        }
    }
}