<?php

namespace framework;


class url {
  
  public static function redirect($url) {
    header('Location: '.$url);
    exit;
  }
  
  public static function getUrlArray() {
    $uri = substr($_SERVER['REQUEST_URI'], strlen(URL_ROOT));
    $urlString = urldecode($uri);
    $urlParts = [];
    if ($urlString) {
      $urlParts = explode('/', $urlString);
    }
    return $urlParts;
  }
  
  public static function controllerExists(string $controllerName, string $subcontrollerName = '') {
    $controllers = [
        'activate',
        'ajax' => [
            'save',
            'create',
        ],
        'create',
        'error',
        'erstellt',
        'fertig',
        'index',
//        'test',
    ];
    
    if (in_array($controllerName, $controllers)) {
      return true;
    }
    
    if (key_exists($controllerName, $controllers)) {
      if (is_array($controllers[$controllerName])) {
        return in_array($subcontrollerName, $controllers[$controllerName]);
      }
    }
    
    return false;
  }
  
}