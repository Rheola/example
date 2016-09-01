<?php
/**
 * @var $this  Controller
 */

$this->menu = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Отзывы', 'url' => '/review'],
];

if($this->user->isAuth()){
    $this->menu[] = ['label' => 'Админка', 'url' => '/review/admin'];
    $this->menu[] = ['label' => 'Выход', 'url' => '/site/logout'];
} else{
    $this->menu[] = ['label' => 'Вход', 'url' => '/site/login'];

}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?= $this->pageTitle; ?></title>
    <script src="/js/jquery-3.1.0.min.js"></script>


    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>

<div class="container">

    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"> Тестовое задание</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?
                    $class = '';

                    foreach($this->menu as $item){
                        $class = '';
                        if($this->getId() == $item['url']){
                            $class = 'class="active"';
                        }
                        ?>
                        <li <?= $class; ?>>
                            <a href="<?= $item['url']; ?>"><?= $item['label']; ?></a>
                        </li>
                        <?
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php include 'application/views/'.$template.'.php'; ?>


</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
