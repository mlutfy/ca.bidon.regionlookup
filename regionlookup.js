cj(function ($) {
  // The "source" is the DOM selector that triggers the lookup (ex: postcode field)
  if (! CRM.regionlookup.source) {
    return;
  }

  $(CRM.regionlookup.source).change(function() {
    if (! $(this).val()) {
      return;
    }

    var query = CRM.url('civicrm/regionlookup/postcode/') + $(this).val() + '.json';

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
});
