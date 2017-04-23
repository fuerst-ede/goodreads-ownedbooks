<?php

namespace framework;

use exception\fileNotFound;

abstract class controller
{
  
  var $constants;
  var $page = '';
  var $parts;
  var $path = '';
  var $vars;
  
  public function __construct() {
    $this->constants = new \stdClass();
    $this->constants->cssPath = URL_ROOT . 'css/';
    $this->constants->jsPath = URL_ROOT . 'js/';
    $this->constants->urlRoot = URL_ROOT;
    $this->parts = new \stdClass();
    $this->vars = new \stdClass();
  }
  
  public function loadTemplate(string $template = 'general') {
    $filePath = APP_ROOT . 'view/template/' . $template . '.php';
    if (file_exists($filePath)) {
      $this->page = file::readFile($filePath, $this);
    }
    else {
      throw new fileNotFound();
    }
  }
  
  public function loadPart(string $view = 'index', string $targetname = '') {
    $filePath = APP_ROOT . 'view/' . $this->path . $view . '.php';
    if (!$targetname) {
      $targetname = $view;
    }
    if (file_exists($filePath)) {
      $this->parts->$targetname = file::readFile($filePath, $this);
    }
    else {
      throw new fileNotFound();
    }
  }
  
  public function getMail(string $view = 'index') {
    $filePath = APP_ROOT . 'view/mail/' . $view . '.php';
    if (file_exists($filePath)) {
      return file::readFile($filePath, $this);
    }
    else {
      throw new fileNotFound();
    }
  }
  
  public function translateBool($value) {
    return $value ? "Ja" : "Nein";
  }
  
  public function convertDatetime($datetime) {
    return preg_replace('/([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2})/', '$3.$2.$1', $datetime);
  }
  
  public function render() {
    echo $this->page;
  }

  abstract public function run();
  
  
  
}