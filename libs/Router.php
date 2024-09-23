<?php

namespace App;

class Router {
    private $routes = [];

    public function add($route, $params = []) {
        $this->routes[$route] = $params;
    }

    public function dispatch($url) {
        $url = $this->removeQueryString($url);

        if ($this->match($url)) {
            $controllerName = $this->routes[$url]['controller'];
            $methodName = $this->routes[$url]['action'];

            $controllerName = 'App\\Controllers\\' . $controllerName;
            if (class_exists($controllerName)) {
                $controller = new $controllerName(new \App\App());

                if (method_exists($controller, $methodName)) {
                    call_user_func_array([$controller, $methodName], []);
                } else {
                    echo "Method $methodName not found in controller $controllerName.";
                }
            } else {
                echo "Controller class $controllerName not found.";
            }
        } else {
            echo "No route matched.";
        }
    }

    private function match($url) {
        return array_key_exists($url, $this->routes);
    }

    private function removeQueryString($url) {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
}
