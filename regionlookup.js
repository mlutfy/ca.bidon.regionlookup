cj(function ($) {
  // The "source" is the DOM selector that triggers the lookup (ex: postcode field)
  if (! CRM.regionlookup.source) {
    return;
  }

  $(CRM.regionlookup.source).change(function() {
    if (! $(this).val()) {
      return;
    }

    var query = '/civicrm/regionlookup/postcode/' + $(this).val() + '.json';

    $.getJSON(query, function(data) {
      if (data) {
        $.each(data, function(key, val) {
          if (key != 'source' && CRM.regionlookup[key]) {
            $(CRM.regionlookup[key]).val(val).change();
          }
        });
      }

      // Call a custom callback function, if any
      if (CRM.regionlookup.callback) {
        eval(CRM.regionlookup.callback + '(data)');
      }
    });
  });

/* Is this just old code? */
/*

  $('#Contact #address_1_postal_code', context).change(function() {
    var query = '/civicrm_regionlookup/postcode/' + $(this).val() + '.json';

    $.getJSON(query, function(data) {
      $.each(data, function(key, val) {
        if (key != 'source' && settings.civicrmRegionLookup[key]) {
          var fieldid = settings.civicrmRegionLookup[key];

          if (fieldid.substr(0, 8) == '#custom_') {
            fieldid += '_-1';
          }

          $(fieldid).val(val).change();
        }
      });

      // Call a custom callback function, if any
      if (settings.civicrmRegionLookup.callback) {
        eval(settings.civicrmRegionLookup.callback + '(data)');
      }
    });
  });
*/

});

