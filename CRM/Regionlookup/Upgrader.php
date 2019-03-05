<?php

use CRM_Regionlookup_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Regionlookup_Upgrader extends CRM_Regionlookup_Upgrader_Base {

  public function upgrade_4602() {
    // Move all settings from old format to new format
    $settings = array();
    $updated = FALSE;

    $regionlookup_fields = array(
      'city',
      'source',
      'source_country',
      'district',
      'borough',
      'county',
      'state',
      'country',
      'postcode',
      'stateriding',
      'countryriding',
      'callback',
    );
    $regionlookup_yesno = array(
      'searchprefix',
      'searchwildcard',
      'searchonkeyup',
    );
    $regionlookup_other = array(
      'searchchars',
      'lookup_method'
    );
    foreach ($regionlookup_fields as $skey) {
      $settings['fields'][$skey] = CRM_Core_BAO_Setting::getItem('RegionLookup Extension', $skey);
    }
    foreach ($regionlookup_yesno as $skey) {
      $settings['yesno'][$skey] = CRM_Core_BAO_Setting::getItem('RegionLookup Extension', $skey);
    }
    foreach ($regionlookup_other as $skey) {
      $settings['other'][$skey] = CRM_Core_BAO_Setting::getItem('RegionLookup Extension', $skey);
    }
    // Since we have now gathered the settings, store them
    try {
      Civi::settings()->set('regionlookup_settings', $settings);
      $updated = TRUE;
    }
    catch (Exception $ex) {
      CRM_Core_Error::debug_log_message("Unable to store settings. Error: " . $ex);
    }

    if ($updated) {
      // Remove the old settings from the registry
      $delete_query = "DELETE FROM `civicrm_setting` WHERE `name` IN ('" . implode("','", $regionlookup_fields) . "','" . implode("','", $regionlookup_yesno) . "','" . implode("','", $regionlookup_other) . "')";
      try {
        $dao = CRM_Core_DAO::executeQuery($delete_query);
      }
      catch (Exception $ex) {
        CRM_Core_Error::debug_log_message("Regionlookup setting cleanup query error: " . $ex);
      }
    }
    return TRUE;
  }

  public function upgrade_4601() {
    $this->ctx->log->info('Applying update 4601');
    $this->executeSqlFile('sql/regionlookup_4601.sql');
    return TRUE;
  }

}
