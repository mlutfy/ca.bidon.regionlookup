<?php

/**
 * Returns the matching entries for a given search lookup.
 * Assumes our lookup is a postcode, but could be another field.
 */
class CRM_RegionLookup_Page_Postcode extends CRM_Core_Page {
  function run() {
    $result = NULL;

    // A mostly useless verification to make sure we are called
    // from /civicrm/regionlookup/postcode/[...], but we need
    // to extract the postcode from, for example:
    // civicrm/regionlookup/postcode/h1h2h2.json
    $config = CRM_Core_Config::singleton();
    $urlVar = $config->userFrameworkURLVar;
    $arg = explode('/', $_GET[$urlVar]);

    $fields = CRM_RegionLookup_BAO_RegionLookup::getFields();
    $settings = CRM_Core_BAO_Setting::getItem(REGIONLOOKUP_SETTINGS_GROUP);

    if ($arg[1] == 'regionlookup' && $arg[2] == 'postcode') {
      $postcode = $arg[3];

      // Clean out the .json suffix
      $postcode = str_replace('.json', '', $postcode);

      if (! empty($settings['lookup_method'])) {
        if (class_exists($settings['lookup_method'])) {
          // Classes must implement 'lookup'. This is our cheap way of enforcing
          // a minimum of security and make sure we're not calling random functions
          // because of a config error.
          $class = $settings['lookup_method'];
          $results = call_user_func(array($class, 'lookup'), $postcode);
        }
        else {
          $results = CRM_RegionLookup_BAO_RegionLookup::lookup($postcode);
        }
      }
      else {
        $results = CRM_RegionLookup_BAO_RegionLookup::lookup($postcode);
      }

      // FIXME: this for backwards compat, where we expect only one result.
      if (! empty($results)) {
        $result = $results[0];
      }
    }

    echo json_encode($result);
    CRM_Utils_System::civiExit();
  }

}
