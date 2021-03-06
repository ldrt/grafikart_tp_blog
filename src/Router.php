<?php
namespace App;

use AltoRouter;
use App\Security\ForbiddenException;

class Router {
    /**
     * @var string
     */
    private $viewpath;
    /**
     * @var AltoRouter
     */
    private $router;

    public function __construct(string $viewPath)
    {
        $this->viewpath = $viewPath;
        $this->router = new AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null) : self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null) : self
    {
        $this->router->map('POST', $url, $view, $name);
        return $this;
    }

    public function match(string $url, string $view, ?string $name = null) : self
    {
        $this->router->map('POST|GET', $url, $view, $name);
        return $this;
    }

    public function url(string $name, array $params = []) : string
    {
        return $this->router->generate($name, $params);
    }

    public function run() : self
    {
        $match = $this->router->match();
        if($match === false){
            $view = 'e404';
        } else {     
            $view = $match['target']; 
            $params = $match['params'];
            $router = $this;
        }  
        $isAdmin = strpos($view, 'admin/') !== false;
        $layout = $isAdmin ? 'admin/layouts/default' : 'layouts/default';
        try {
            ob_start();
            require $this->viewpath  . DIRECTORY_SEPARATOR . $view . '.php';
            $content = ob_get_clean();
            require $this->viewpath . DIRECTORY_SEPARATOR . $layout . '.php';
        } catch (ForbiddenException $e) {
            header('Location: ' . $this->url('login') . '?forbidden=1');
            exit();
        }
        return $this;
    }
}
?>