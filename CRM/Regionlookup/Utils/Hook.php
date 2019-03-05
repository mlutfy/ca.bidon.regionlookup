<?php

class CRM_Regionlookup_Utils_Hook {
  static $_nullObject = NULL;

  /**
   * This hook is called to get a list of extensions implementing the
   * regionlookup function.
   *
   * @return mixed
   *   based on op. pre-hooks return a boolean or
   *                           an error message which aborts the operation
   */
  public static function getRegionLookupClasses(&$classes) {
    $hook = CRM_Utils_Hook::singleton();
    return $hook->invoke(1, $classes, self::$_nullObject, self::$_nullObject, self::$_nullObject, self::$_nullObject, self::$_nullObject, 'civicrm_regionlookup_config');
  }
}
