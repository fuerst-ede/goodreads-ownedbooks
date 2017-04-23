<?php

namespace controller;

use framework\controller;
use framework\url;

class index extends controller {
  
  var $path = 'index/';
  
  public function run() {
    
    $urlParts = url::getUrlArray();
    
    try {
      $this->loadPart('main');
      $this->loadTemplate();
      $this->render();
    }
    catch (\Exception $e) {
      die('File not found');
    }
  }
  
}