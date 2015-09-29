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

class CRM_Admin_Form_Setting_RegionLookup extends CRM_Admin_Form_Setting {
  protected $_values;

  function setDefaultValues() {
    return CRM_Core_BAO_Setting::getItem(REGIONLOOKUP_SETTINGS_GROUP);
  }

  public function buildQuickForm() {
    $fields = CRM_RegionLookup_BAO_RegionLookup::getFields();
    $yesno = CRM_RegionLookup_BAO_RegionLookup::getSearchYesNoOptions();
    $other = CRM_RegionLookup_BAO_RegionLookup::getSearchOtherOptions();

    foreach ($fields as $key => $label) {
      $this->add('text', $key, $label);
    }

    foreach ($yesno as $key => $label) {
      $this->addYesNo($key, $label);
    }

    foreach ($other as $key => $label) {
      $this->add('text', $key, $label);
    }

    $lookup_methods = CRM_RegionLookup_BAO_RegionLookup::getLookupMethods();
    $this->addRadio('lookup_method', ts("Lookup method"), $lookup_methods, TRUE);

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

    $fields = CRM_RegionLookup_BAO_RegionLookup::getFields();
    foreach ($fields as $key => $label) {
      $value = $params[$key];
      $result = CRM_Core_BAO_Setting::setItem($value, REGIONLOOKUP_SETTINGS_GROUP, $key);
    }

    $yesno = CRM_RegionLookup_BAO_RegionLookup::getSearchYesNoOptions();
    foreach ($yesno as $key => $label) {
      $value = $params[$key];
      $result = CRM_Core_BAO_Setting::setItem($value, REGIONLOOKUP_SETTINGS_GROUP, $key);
    }

    $other = CRM_RegionLookup_BAO_RegionLookup::getSearchOtherOptions();
    foreach ($other as $key => $label) {
      $value = $params[$key];
      $result = CRM_Core_BAO_Setting::setItem($value, REGIONLOOKUP_SETTINGS_GROUP, $key);
    }

    // Lookup method
    CRM_Core_BAO_Setting::setItem($params['lookup_method'], REGIONLOOKUP_SETTINGS_GROUP, 'lookup_method');

    CRM_Core_Session::setStatus(ts('Settings saved.'), '', 'success');
  }
}

