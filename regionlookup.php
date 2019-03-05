<?php

// define('REGIONLOOKUP_SETTINGS_GROUP', 'RegionLookup Extension');
require_once 'regionlookup.civix.php';

use CRM_Regionlookup_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function regionlookup_civicrm_config(&$config) {
  _regionlookup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function regionlookup_civicrm_xmlMenu(&$files) {
  _regionlookup_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function regionlookup_civicrm_install() {
  _regionlookup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function regionlookup_civicrm_postInstall() {
  _regionlookup_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function regionlookup_civicrm_uninstall() {
  _regionlookup_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function regionlookup_civicrm_enable() {
  _regionlookup_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function regionlookup_civicrm_disable() {
  _regionlookup_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function regionlookup_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _regionlookup_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function regionlookup_civicrm_managed(&$entities) {
  _regionlookup_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function regionlookup_civicrm_caseTypes(&$caseTypes) {
  _regionlookup_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function regionlookup_civicrm_angularModules(&$angularModules) {
  _regionlookup_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function regionlookup_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _regionlookup_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function regionlookup_civicrm_entityTypes(&$entityTypes) {
  _regionlookup_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 * */
function regionlookup_civicrm_navigationMenu(&$menu) {
  _regionlookup_civix_insert_navigation_menu($menu, 'Administer', array(
    'label' => E::ts('Region Lookup Settings'),
    'name' => 'region_lookup_settings',
    'url' => 'civicrm/admin/setting/regionlookup',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _regionlookup_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * Injects the settings to know on which field to trigger the lookup.
 * Assumes that this module runs only on proper forms, not pages.
 */
function regionlookup_civicrm_buildForm($formName, &$form) {
  static $settings_already_set = FALSE;

  // Run only once (ex: for forms with ajax custom fields)
  if ($settings_already_set) {
    return;
  }

  $settings = array();
  $stored_settings = Civi::settings()->get('regionlookup_settings');
  // Get all settings
  $fields = CRM_Regionlookup_BAO_Regionlookup::getFields();
  foreach ($fields as $key => $value) {
    $settings[$key] = $stored_settings['fields'][$key];
  }
  $yesno = CRM_Regionlookup_BAO_Regionlookup::getSearchYesNoOptions();
  foreach ($yesno as $key => $value) {
    $settings[$key] = $stored_settings['yesno'][$key];
  }
  $other = CRM_Regionlookup_BAO_Regionlookup::getSearchOtherOptions();
  foreach ($other as $key => $value) {
    $settings[$key] = $stored_settings['other'][$key];
  }

  $translations = array(
    'tr_multiple_records_title' => ts("Multiple results were found. Please select your preferred option by clicking on the link(s) below", array('domain' => 'ca.bidon.regionlookup')),
    'tr_multiple_results' => ts('Multiple results found', array('domain' => 'ca.bidon.regionlookup')),
    'tr_city' => ts('City'),
    'tr_city_selector' => ts('Please select a city', array('domain' => 'ca.bidon.regionlookup')),
  );

  if ($formName == 'CRM_Contact_Form_Contact' || $formName == 'CRM_Contact_Form_Inline_Address' || $formName == 'CRM_Activity_Form_ActivityLinks') {
    CRM_Core_Resources::singleton()
      ->addScriptFile('ca.bidon.regionlookup', 'templates/CRM/Regionlookup/Custom/regionlookup.js')
      ->addSetting(array('regionlookup' => $settings + $translations));
  }

  $settings_already_set = TRUE;
}
