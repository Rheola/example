<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 10:56
 */
class ReviewController extends Controller{

    public function actionIndex(){
        $order = 'creation_date desc';
        if(isset($_GET['order'])){
            $order = $_GET['order'];
        }
        $model = new Review();

        if(isset($_POST['Review'])){
            $post = $_POST['Review'];
            $model->email = $post['email'];
            $model->name = $post['name'];
            $model->text = $post['text'];
            if($model->validate()){
                if(!$model->save('review')){
                    $model->addError('Ошибка записи в базу данных');
                } else{
                    if(isset($_FILES['Review'])){
                        if(!$model->uploadFile()){
                            throw  new ErrorException('Ошибка загрузки файла');
                        };
                        $model->save('review');
                    }
                    header('Location: '.'index', true, 302);
                }
            }
        }

        $reviews = Review::findAll([
            'where' => 'show = 1',
            'order' => $order
        ]);

        $this->render('index', [
            'reviews' => $reviews,
            'model' => $model,
        ]);
    }

    public function actionAdmin(){

        if(!$this->user->isAuth()){
            header('Location: /site/login', true);
        }
        $reviews = Review::findAll(['order' => 'id desc']);
        $this->render('admin', ['reviews' => $reviews]);
    }

    public function actionUpdate(){

        if(!isset($_GET['id'])){
            throw  new ErrorException('Неверный формат запроса');
        }
        if(!$this->user->isAuth()){
            header('Location: /site/login', true);
        }
        $id = $_GET['id'];

        $model = Review::findOne('review', $id);
        if($model == null){
            throw  new ErrorException('Запись не найдена');
        }
        if(isset($_POST['Review'])){
            $post = $_POST['Review'];
            $model->text = $post['text'];
            $model->edited = 1;
            if($model->validate()){
                if(!$model->save('review')){
                    $model->addError('Ошибка записи в базу данных');
                } else{
                    header('Location: '.'index', true, 302);
                }
            }
        }
        $this->render('update', ['model' => $model]);
    }

    public function actionPublic(){
        if(!$this->user->isAuth()){
            header('Location: /site/login', true);
        }

        if(!isset($_GET['id'])){
            throw  new ErrorException('Неверный формат запроса');
        }

        $id = $_GET['id'];

        $model = Review::findOne('review', $id);
        if($model == null){
            throw  new ErrorException('Запись не найдена');
        }
        $model->show = 1;
        if($model->validate()){
            if(!$model->save('review')){
                throw  new ErrorException('Ошибки записи в базу');
            } else{
                header('Location: '.'admin', true, 302);
            }
        }
        throw  new ErrorException('Ошибка валидации');
    }

    public function actionDecline(){
        if(!$this->user->isAuth()){
            header('Location: /site/login', true);
        }
        if(!isset($_GET['id'])){
            throw  new ErrorException('Неверный формат запроса');
        }

        $id = $_GET['id'];

        $model = Review::findOne('review', $id);
        if($model == null){
            throw  new ErrorException('Запись не найдена');
        }
        $model->show = 2;
        if($model->validate()){
            if(!$model->save('review')){
                throw  new ErrorException('Ошибки записи в базу');
            } else{
                header('Location: '.'admin', true, 302);
            }
        }
        throw  new ErrorException('Ошибка валидации');
    }
}