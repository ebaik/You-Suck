<?php
// KFID Client 1.1 2011-05-24
// Example Derived Logger for common logging interface for all games

require_once("BaseLogger.php");

class DerivedLogger extends BaseLogger
{
  public static function info($message) {
    echo "INFO: ". $message. "\n";
  }

  public static function debug($message) {
    echo "DEBUG: ". $message. "\n";
  }

  public static function error($message) {
    echo "ERROR: ". $message. "\n";
    throw new Exception("Error: {$message}");
  }

}