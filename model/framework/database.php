<?php

namespace framework;


use exception\configDataMissing;
use exception\noMysqlConnection;

class database {

  var $dbRes;

  public function __construct() {
    if (!defined('MYSQL_HOST') || !defined('MYSQL_USER') || !defined('MYSQL_PASS') || !defined('MYSQL_DB')) {
      throw new configDataMissing();
    }
    try {
      $this->dbRes = new \PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=UTF8', MYSQL_USER, MYSQL_PASS);
    }
    catch (\PDOException $e) {
      throw new noMysqlConnection();
    }
  }

  /**
   * @return \PDO
   */
  public static function getDBRes() {
    if (!key_exists('db', $_ENV) || !$_ENV['db']) {
      $_ENV['db'] = new database();
    }
    return $_ENV['db']->dbRes;
  }

}