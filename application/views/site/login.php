<?php
/**
 *
 * @var SiteController $this
 * @var LoginForm $loginForm
 */
?>
<h2>Авторизация</h2>

<div class="col-md-6 col-md-push-2">
    <form method="post" action="/site/login">
        <div class="form-group">
            <label for="login">Логин </label>
            <input type="text" class="form-control" placeholder="логин" name='LoginForm[login]'>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" placeholder="пароль" name='LoginForm[password]'>
        </div>

        <?
        if($loginForm->hasErrors()){
            ?>
            <div class='form-group bg-danger'>
                <ul>
                    <? echo $loginForm->getErrors(); ?>
                </ul>
            </div>
            <?
        }
        ?>

        <button type="submit" class="btn btn-default">Войти</button>
    </form>
</div>
<div class="col-md-2"></div>