<?php

class Router
{

    private $basepath;
    private $uri;
    private $base_url;
    private $routes;
    private $params;
    private $explode_params;

    function __construct($explode_params = true)
    {
        $this->explode_params = $explode_params;
        $this->explodeRoute();
    }

    private function explodeRoute()
    {
        $this->base_url = $this->explodeCurrentUri();
        $this->routes = explode('/', $this->base_url);
        if (strpos($this->routes[sizeof($this->routes) - 1], '?') !== false)
            $this->routes[sizeof($this->routes) - 1] = substr($this->routes[sizeof($this->routes) - 1], 0, strpos($this->routes[sizeof($this->routes) - 1], '?'));
    }

    private function explodeCurrentUri()
    {
        $this->basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $this->uri = substr($_SERVER['REQUEST_URI'], strlen($this->basepath));

        if ($this->explode_params) {
            $this->explodeParams();
        } else {
            if (strstr($this->uri, '?'))
                $this->uri = substr($this->uri, 0, strpos($this->uri, '?'));
        }

        $this->uri = '/' . trim($this->uri, '/');
        return $this->uri;
    }

    private function explodeParams()
    {
        if (strstr($this->uri, '?')) {
            $params = explode("?", $this->uri);
            $params = $params[1];

            parse_str($params, $this->params);
            $this->routes[0] = $this->params;
            array_pop($this->routes);
        }
    }

    public function get($index = 0)
    {
        return isset($this->routes[$index]) ? $this->routes[$index] : false;
    }

    public function param($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : false;
    }
}
