<? class Route{

    public static function start(){

        $controller_name = 'Site';
        $action_name = 'index';

        $tail = explode('?', $_SERVER['REQUEST_URI']);

        $routes = explode('/', $tail[0]);

        if(!empty($routes[1])){
            $controller_name = $routes[1];
        }


        if(!empty($routes[2])){
            $action_name = $routes[2];
        }


        $model_name = $controller_name;
        if($controller_name == 'index.php'){
            header('Location: /', true, 302);
        }
        $controller_name = $controller_name.'Controller';

        $action_name = 'action'.lcfirst($action_name);


        $model_file = $model_name.'.php';
        $model_path = 'application/models/'.$model_file;
        if(file_exists($model_path)){
            include 'application/models/'.$model_file;
        }

        $controller_file = $controller_name.'.php';
        $controller_path = 'application/controllers/'.$controller_file;
        if(file_exists($controller_path)){
            include 'application/controllers/'.$controller_file;
        } else{

            throw new ErrorException(sprintf('Контроллер %s не найден', $controller_name));
        }

        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action)){
            $controller->$action();
        } else{
            throw new ErrorException(sprintf('Метод %s в контроллере %s не найден', $action, $controller_name));
        }
    }
}
