<?php

/**
 * This class contains helper functions.
 */
class CRM_Regionlookup_BAO_Regionlookup {
  /**
   * Returns a list of fields handled by the extension.
   * Used by the admin settings forms, as well as the ajax response function.
   */
  static function getFields() {

    return array(
      'source' => ts('Field selector (trigger)'),
      'source_country' => ts('Field selector for country (additional trigger) - Optional'),
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
      'CRM_Regionlookup_BAO_RegionLookup' => ts('Database'),
    );

    CRM_Regionlookup_Utils_Hook::getRegionLookupClasses($methods);
    return $methods;
  }

  /**
   *
   * Returns an array of results.
   */
  static function lookup($postcode, $country = null) {

    $instance = new CRM_Regionlookup_BAO_Regionlookup();
    $results  = $settings = array();

    // Get all settings
    $fields = $instance::getFields();
    $stored_settings = Civi::settings()->get('regionlookup_settings');
    foreach ($fields as $key => $value) {
      $settings[$key] = $stored_settings['fields'][$key];
    }
    $yesno  = $instance::getSearchYesNoOptions();
    foreach ($yesno as $key => $value) {
      $settings[$key] = $stored_settings['yesno'][$key];
    }
    $other  = $instance::getSearchOtherOptions();
    foreach ($other as $key => $value) {
      $settings[$key] = $stored_settings['other'][$key];
    }

    // Transform to lowercase, and remove anything non-alphanumeric
    $postcode = strtolower($postcode);
    $postcode = preg_replace('/[^a-z0-9]/', '', $postcode);

    $query = 'SELECT * FROM civicrm_regionlookup WHERE postcode = %1';

    $params = array(
      1 => array($postcode, 'String'),
    );
    // If we got a country specified, filter by that country
    if (!is_null($country) && $country != 'all') {
      $query .= ' AND country = %2';
      $params[2] = array($country, 'String');
    }

    if ($settings['searchprefix']) {
      $string = substr($postcode, 0, -1);
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
      foreach ($yesno as $key => $fieldname) {
        $result[$key] = $dao->$key;
      }
      foreach ($other as $key => $fieldname) {
        $result[$key] = $dao->$key;
      }

      $results[] = $result;
    }

    return $results;
  }

}
