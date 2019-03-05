<?php

/*
 +--------------------------------------------------------------------------+
 | Copyright (C) 2011-2013 Mathieu Lutfy                                    |
 | This file is part of CiviCRM Region Lookup (ca.bidon.regionlookup).      |
 |                                                                          |
 | Based on code (C) 2013 Nicolas Ganivet (CiviDesk)                        |
 | in various other CiviCRM extensions, such as ca.bidon.reporterror.       |
 +--------------------------------------------------------------------------+
 | This program is free software: you can redistribute it and/or modify     |
 | it under the terms of the GNU Affero General Public License as published |
 | by the Free Software Foundation, either version 3 of the License, or     |
 | (at your option) any later version.                                      |
 |                                                                          |
 | This program is distributed in the hope that it will be useful,          |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
 | GNU Affero General Public License for more details.                      |
 |                                                                          |
 | You should have received a copy of the GNU Affero General Public License |
 | along with this program.  If not, see <http://www.gnu.org/licenses/>.    |
 +--------------------------------------------------------------------------+
*/

define('REGIONLOOKUP_SETTINGS_GROUP', 'RegionLookup Extension');
define('REGIONLOOKUP_SETTINGS_NAME', 'regionlookup');

require_once 'regionlookup.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function regionlookup_civicrm_config(&$config) {
  _regionlookup_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function regionlookup_civicrm_xmlMenu(&$files) {
  _regionlookup_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function regionlookup_civicrm_install() {
  return _regionlookup_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function regionlookup_civicrm_uninstall() {
  return _regionlookup_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function regionlookup_civicrm_enable() {
  return _regionlookup_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function regionlookup_civicrm_disable() {
  return _regionlookup_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function regionlookup_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _regionlookup_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function regionlookup_civicrm_managed(&$entities) {
  return _regionlookup_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_navigationMenu
 */
function regionlookup_civicrm_navigationMenu( &$params ) {
  // Inserts a navigation item in the menu, assuming the admin has not completely changed it.
  _regionlookup_civix_insert_navigationMenu($params, 'Administer/System Settings', array(
    'name' => 'Region Lookup Settings',
    'url' => 'civicrm/admin/setting/regionlookup',
    'permission' => 'administer CiviCRM',
  ));
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

  $settings = CRM_Core_BAO_Setting::getItem(REGIONLOOKUP_SETTINGS_GROUP, REGIONLOOKUP_SETTINGS_NAME);


  CRM_Core_Resources::singleton()
    ->addScriptFile('ca.bidon.regionlookup', 'regionlookup.js')
    ->addSetting(array('regionlookup' => $settings));

  $settings_already_set = TRUE;
}

