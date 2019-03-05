<?php

/**
 * Collection of upgrade steps
 */
class CRM_RegionLookup_Upgrader extends CRM_RegionLookup_Upgrader_Base {

  // By convention, functions that look like "function upgrade_NNNN()" are
  // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

  /**
   * Run the external SQL script when the module is installed.
   */
  public function install() {
    // $this->executeSqlFile('sql/regionlookup-install.sql');
  }

  /**
   * Run the external SQL script when the module is uninstalled.
   */
  public function uninstall() {
    // $this->executeSqlFile('sql/regionlookup-uninstall.sql');
  }

  /**
   * Example: Run a simple query when a module is enabled
   */
  public function enable() {
    // CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 1 WHERE bar = "whiz"');
  }

  /**
   * Example: Run a simple query when a module is disabled
   */
  public function disable() {
    // CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 0 WHERE bar = "whiz"');
  }

  /**
   * Upgrade to CiviCRM 4.7 - all settings in one civicrm_setting entry with a specific name
   *
   * @return TRUE on success
   * @throws Exception
   */
  public function upgrade_4701() {
    $this->ctx->log->info('Planning update 4701'); // PEAR Log interface

    $fields = CRM_RegionLookup_BAO_RegionLookup::getFields();
    $yesno = CRM_RegionLookup_BAO_RegionLookup::getSearchYesNoOptions();
    $other = CRM_RegionLookup_BAO_RegionLookup::getSearchOtherOptions();

    $items = $fields + $yesno + $other;
    $values = array();
    foreach ($items as $key => $label) {
      $value = CRM_Core_BAO_Setting::getItem(NULL, $key);
      $values[$key] = $value;
    }

    $result = CRM_Core_BAO_Setting::setItem($values, REGIONLOOKUP_SETTINGS_GROUP, REGIONLOOKUP_SETTINGS_NAME);

    return TRUE;
  }
}

