<?php
/**
 * Created by PhpStorm.
 * User: jenswalter
 * Date: 29.01.17
 * Time: 19:16
 */

namespace framework;


abstract class dataobject {

  var $ID = 0;

  var $transients = ['transients'];

  const TABLE_NAME = 'dataobject';

  /**
   * @param int $id If an id is given the object will be loaded if available
   */
  public function __construct($ID = 0) {
    if ($ID) {
      $this->ID = (int) $ID;
      $this->loadData();
    }
  }

  public function save() {
    $dbr = database::getDBRes();
    if (!$this->ID) {

      $fieldArray = array();
      $placeholderArray = array();
      $valueArray = array();
      foreach ($this as $key => $value) {
        if ($key != "ID" && !in_array($key, $this->transients)) {
          $fieldArray[] = $key;
          $placeholderArray[] = ':' . $key;
          $valueArray[] = $value;
        }
      }

      $fieldString = implode(',', $fieldArray);
      $placeHolderString = implode(',', $placeholderArray);
      $sql = 'INSERT INTO ' . static::TABLE_NAME . ' (' . $fieldString . ') VALUES (' . $placeHolderString . ')';

      $prepStatement = $dbr->prepare($sql);
      for($i=0;$i<count($placeholderArray);$i++) {
        $prepStatement->bindValue($placeholderArray[$i], $valueArray[$i]);
      }
      if (!$prepStatement->execute()) {
        print_r($prepStatement->errorInfo());
      }

      $this->ID = $dbr->lastInsertId();

    } else {

      $fieldArray = array();
      $placeholderArray = array();
      $valueArray = array();
      foreach ($this as $key => $value) {
        if ($key != "ID" && !in_array($key, $this->transients)) {
          $fieldArray[] = $key . ' = :' . $key;
          $placeholderArray[] = ':' . $key;
          $valueArray[] = $value;
        }
      }

      $fieldString = implode(',', $fieldArray);
      $sql = 'UPDATE ' . static::TABLE_NAME . ' SET ' . $fieldString . ' WHERE ID = :id';

      $prepStatement = $dbr->prepare($sql);
      $prepStatement->bindValue(':id', $this->ID);
      for($i=0;$i<count($placeholderArray);$i++) {
        $prepStatement->bindValue($placeholderArray[$i], $valueArray[$i]);
      }
      $prepStatement->execute();

    }
  }

  public function delete() {
    if ($this->ID) {
      $dbr = database::getDBRes();
      $dbr->query('DELETE FROM ' . static::TABLE_NAME . ' WHERE ID=' . (int)$this->ID);
      $this->ID = 0;
    }
  }

  /**
   * Load data belonging to the ID of this object into the object ando overwrite everything in the object
   */
  public function loadData() {
    if ($this->ID) {
      $dbr = database::getDBRes();
      $pdoStatement = $dbr->query('SELECT * FROM ' . static::TABLE_NAME . ' WHERE ID=' . (int)$this->ID);
      if ($pdoStatement) {
        $dataObject = $pdoStatement->fetch(\PDO::FETCH_OBJ);
        if ($dataObject) {
          foreach ($this as $key => $value) {
            if (!in_array($key, $this->transients) && $key!='ID') {
              $this->{$key} = $dataObject->{$key};
            }
          }
        }
      }
      else {
        $this->ID = 0;
      }
    }
  }

  public function setData($data) {
    foreach ($this as $key => $value) {
      if ($key != "ID") {
        if (isset($data[$key])) {
          $this->$key = $data[$key];
        }
      }
    }
  }

  public static function convertDatetime($datetime) {
    return preg_replace('/([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2})/', '$3.$2.$1', $datetime);
  }

  public static function convertDatetimeToDB($datetime) {
    return preg_replace('/([0-9]{1,2})\\.([0-9]{1,2})\\.([0-9]{1,4})/', '$3-$2-$1', $datetime);
  }

  public static function checkEmail($value) {

    if ($value=="")
      return true;

    $atIndex = strrpos($value, "@");
    if (is_bool($atIndex) && !$atIndex)
      return false;

    $domain = substr($value, $atIndex+1);
    $local = substr($value, 0, $atIndex);
    $localLen = strlen($local);
    $domainLen = strlen($domain);

    if ($localLen < 1 || $localLen > 64)
      return false;

    if ($domainLen < 1 || $domainLen > 255)
      return false;

    if ($local[0] == '.' || $local[$localLen-1] == '.')
      return false;

    if (preg_match('/\\.\\./', $local))
      return false;

    if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      return false;

    if (preg_match('/\\.\\./', $domain))
      return false;

    if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
      if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
        return false;
    }

    return true;

  }


}