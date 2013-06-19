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
}

