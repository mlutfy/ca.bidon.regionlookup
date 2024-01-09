<?php

use CRM_RegionLookup_ExtensionUtil as E;

return [
  [
    'name' => 'Navigation_regionlookup_settings',
    'entity' => 'Navigation',
    'cleanup' => 'unused',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'label' => E::ts('Region Lookup'),
        'name' => 'regionlookup_setting',
        'url' => 'civicrm/admin/setting/regionlookup',
        'icon' => '',
        'permission' => [
          'administer CiviCRM',
        ],
        'permission_operator' => 'OR',
        'parent_id.name' => 'System Settings',
        'has_separator' => 0,
        'weight' => 90,
      ],
      'match' => [
        'domain_id',
        'name',
      ],
    ],
  ],
];
