<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 10:55
 */
class Review extends Model{

    const Weight = 320;
    const Height = 240;
    public $id;
    public $email;
    public $name;
    public $text;
    public $show;
    public $edited;
    public $creation_date;
    public $file;
    public $file_name;

    public static function model(){
        return new Review();
    }

    public static function tableName(){
        return 'review';
    }

    public static $statuses = [
        'Новый',
        'Опубликован',
        'Отклонен',
    ];

    public function statusName(){
        return self::$statuses[$this->show];
    }


    public function validate(){
        if(strlen($this->email) == 0){
            $this->addError('Заполните поле email');
        }
        if(strlen($this->name) == 0){
            $this->addError('Заполните поле Имя');
        }
        if(strlen($this->text) == 0){
            $this->addError('Заполните поле Текст');
        }
        if(strlen($this->email) > 50){
            $this->addError('email слишком длинный. Максимум 50 символов');
        }
        if(strlen($this->name) > 50){
            $this->addError('Имя слишком длинное. Максимум 50 символов');
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) !== FALSE){
            $this->addError('Неверный  формат Email');
        }

        if(isset($_FILES['Review'])){
            $uFile = $_FILES['Review'];
            if(strlen($uFile['tmp_name']['file']) > 0){
                $path_parts = pathinfo($uFile['name']['file']);
                if(!isset($path_parts['extension'])){
                    $this->addError('Неизвестное расшиерние файла');
                } else{
                    $ext = mb_strtolower($path_parts['extension']);
                    if(!in_array($ext, ['jpg', 'gif', 'png'])){
                        $error = sprintf('Неверный  формат файла - "%s". Доступные форматы JPG, GIF, PNG', $ext);
                        $this->addError($error);
                    }
                }
            }
        }

        return !$this->hasErrors();
    }


    public function uploadFile(){
        $uploadDir = __DIR__.'/../../files/';
        $uFile = $_FILES['Review'];

        $path_info = pathinfo($uFile['name']['file']);
        $ext = strtolower($path_info['extension']);

        $name = sprintf('%d.%s', $this->id, $ext);
        $newFile = $uploadDir.$name;

        $this->file_name = $name;
        $result = move_uploaded_file($uFile['tmp_name']['file'], $newFile);

        if(!$result){
            return false;
        }

        return $this->resizeImage($newFile);
    }

    public static function findAll($params = []){
        $command = new DbCommand();
        $rawData = $command->selectAll('review', $params);
        if($rawData === false){
            return [];
        }
        $data = [];
        foreach($rawData as $item){
            $model = new Review();
            foreach($item as $field => $value){
                $model->$field = $value;
            }
            $data[] = $model;
        }

        return $data;
    }

    public function clearText(){
        return strip_tags($this->text, '<a><br><img><p>');
    }


    /**
     * @param $newFile
     * @return bool
     */
    private function resizeImage($newFile){
        $path_info = pathinfo($newFile);

        $ext = strtolower($path_info['extension']);

        $im = false;
        switch($ext){
            case 'jpg':
                /* Пытаемся открыть */
                $im = @imagecreatefromjpeg($newFile);


                break;
            case 'png':
                $im = @imagecreatefrompng($newFile);

                break;
            case 'gif':
                $im = @imagecreatefromgif($newFile);
                break;
        }
        /* Если не удалось */
        if(!$im){
            return false;
        }
        $size = getimagesize($newFile);
        $ratio = $size[0] / $size[1]; // width/height
        $coef = self::Weight / self::Height;
        if($ratio > $coef){
            $width = self::Weight;
            $height = self::Height / $ratio;
        } else{
            $width = self::Weight * $ratio / $coef;
            $height = self::Height;
        }
        $src = imagecreatefromstring(file_get_contents($newFile));
        $dst = imagecreatetruecolor(self::Weight, self::Height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagedestroy($src);
        imagejpeg($dst, $newFile);
        imagedestroy($dst);

        return true;
    }
}