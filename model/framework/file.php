<?php

namespace framework;

class file {
  
  static function readFile(string $filename, controller $controller) {
    $content = '';
    if (file_exists($filename)) {
      ob_start();
      include ($filename);
      $content = ob_get_contents();
      ob_end_clean();
    }
    return $content;
  }
  
}