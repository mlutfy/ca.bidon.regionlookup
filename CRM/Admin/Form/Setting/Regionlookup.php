<?php

/*
  +--------------------------------------------------------------------------+
  | Copyright (C) 2011-2015 Mathieu Lutfy                                    |
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

class CRM_Regionlookup_Admin_Form_Setting_Regionlookup extends CRM_Admin_Form_Setting {

  protected $_values;

  function setDefaultValues() {
    $defaults = array();
    $retrieved_values = Civi::settings()->get('regionlookup_settings');

    if (count($retrieved_values) > 0) {
      foreach ($retrieved_values as $groupData) {
        foreach ($groupData as $keySetting => $keyData) {
          $defaults[$keySetting] = $keyData;
        }
      }
    }

    return $defaults;
  }

  public function buildQuickForm() {
    $fields = CRM_Regionlookup_BAO_Regionlookup::getFields();
    $yesno = CRM_Regionlookup_BAO_Regionlookup::getSearchYesNoOptions();
    $other = CRM_Regionlookup_BAO_Regionlookup::getSearchOtherOptions();

    foreach ($fields as $key => $label) {
      $this->add('text', $key, $label);
    }

    foreach ($yesno as $key => $label) {
      $this->addYesNo($key, $label);
    }

    foreach ($other as $key => $label) {
      $this->add('text', $key, $label);
    }

    $lookup_methods = CRM_Regionlookup_BAO_Regionlookup::getLookupMethods();
    $this->addRadio('regionlookup_lookup_method', ts("Lookup method"), $lookup_methods, NULL, NULL, TRUE);

    $this->applyFilter('__ALL__', 'trim');

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ),
    ));
  }

  public function postProcess() {
    // store the submitted values in an array
    $params = $this->exportValues();
    $store_settings = array();

    $fields = CRM_Regionlookup_BAO_Regionlookup::getFields();
    foreach ($fields as $key => $label) {
      $store_settings['fields'][$key] = $params[$key];
    }

    $yesno = CRM_Regionlookup_BAO_Regionlookup::getSearchYesNoOptions();
    foreach ($yesno as $key => $label) {
      $store_settings['yesno'][$key] = $params[$key];
    }

    $other = CRM_Regionlookup_BAO_Regionlookup::getSearchOtherOptions();
    foreach ($other as $key => $label) {
      $store_settings['other'][$key] = $params[$key];
    }

    // Lookup method
    $store_settings['other']['regionlookup_lookup_method'] = $params['regionlookup_lookup_method'];

    // Store the settings
    Civi::settings()->set('regionlookup_settings', $store_settings);

    CRM_Core_Session::setStatus(ts('Settings saved.'), '', 'success');
  }

}
