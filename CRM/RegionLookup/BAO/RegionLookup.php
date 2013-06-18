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
}

