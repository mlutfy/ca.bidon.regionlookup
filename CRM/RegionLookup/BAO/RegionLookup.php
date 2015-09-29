<?php

/**
 * This class contains helper functions.
 */
class CRM_RegionLookup_BAO_RegionLookup {
  /**
   * Returns a list of fields handled by the extension.
   * Used by the admin settings forms, as well as the ajax response function.
   */
  static function getFields() {
    return array(
      'source' => ts('Field selector'),
      'district' => ts('District'),
      'borough' => ts('Borough'),
      'city' => ts('City'),
      'county' => ts('County'),
      'state' => ts('State/Province'),
      'country' => ts('Country'),
      'postcode' => ts('Postcode'),
      'stateriding' => ts('State/Province riding'),
      'countryriding' => ts('Country riding'),
      'callback' => ts('Custom callback'),
    );
  }

  /**
   * Returns a list of search yes/no options.
   */
  static function getSearchYesNoOptions() {
    return array(
      'searchprefix' => ts('Enable prefix-searching?'),
      'searchwildcard' => ts('Enable wildcard search?'),
      'searchonkeyup' => ts('Trigger search as the user types?'),
    );
  }

  /**
   * Returns a list of other search options (not very useful for now).
   */
  static function getSearchOtherOptions() {
    return array(
      'searchchars' => ts('How many characters to send to the lookup query?'),
    );
  }

  static function getLookupMethods() {
    $methods = array(
      'CRM_RegionLookup_BAO_RegionLookup' => ts('Database'),
    );

    CRM_RegionLookup_Utils_Hook::getRegionLookupClasses($methods);
    return $methods;
  }

  /**
   *
   * Returns an array of results.
   */
  static function lookup($value) {
    $results = array();

    $fields = CRM_RegionLookup_BAO_RegionLookup::getFields();
    $settings = CRM_Core_BAO_Setting::getItem(REGIONLOOKUP_SETTINGS_GROUP);

    // Transform to lowercase, and remove anything non-alphanumeric
    $value = strtolower($value);
    $value = preg_replace('/[^a-z0-9]/', '', $value);

    $query = 'SELECT * FROM civicrm_regionlookup WHERE postcode = %1';
    $params = array(
      1 => array($value, 'String'),
    );

    if ($settings['searchprefix']) {
      $string = substr($value, 0, -1);
      $cpt = 2;

      while ($string) {
        $params[$cpt] = array($string, 'String');
        $string = substr($string, 0, -1);
        $query .= ' OR postcode = %' . $cpt;
        $cpt++;
      }

      $query .= ' ORDER BY length(postcode) DESC';
    }

    $dao = CRM_Core_DAO::executeQuery($query, $params);

    while ($dao->fetch()) {
      $result = array();

      foreach ($fields as $key => $fieldname) {
        $result[$key] = $dao->$key;
      }

      $results[] = $result;
    }

    return $results;
  }

}
