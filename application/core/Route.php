<? class Route{

    public static function start(){
        $baseDir = __DIR__.'/../../application/';

        $controllerName = 'Site';
        $actionName = 'index';

        $tail = explode('?', $_SERVER['REQUEST_URI']);

        $routes = explode('/', $tail[0]);

        if(!empty($routes[1])){
            $controllerName = $routes[1];
        }

        if(!empty($routes[2])){
            $actionName = $routes[2];
        }

        if($controllerName == 'index.php'){
            header('Location: /', true, 302);
        }
        $model = ucfirst($controllerName);

        $controllerName = ucfirst($controllerName).'Controller';
        $actionName = 'action'.ucfirst($actionName);


        $model_file = $model.'.php';
        $model_path = $baseDir.'models/'.$model_file;
        if(file_exists($model_path)){
            include $model_path;
        }

        $controller_file = $controllerName.'.php';
        $controller_path = $baseDir.'controllers/'.$controller_file;
        if(file_exists($controller_path)){
            include $controller_path;
        } else{
            throw new ErrorException(sprintf('Контроллер %s не найден', $controllerName));
        }

        $controller = new $controllerName;
        $action = $actionName;

        if(method_exists($controller, $action)){
            $controller->$action();
        } else{
            throw new ErrorException(sprintf('Метод %s в контроллере %s не найден', $action, $controllerName));
        }
    }
}
