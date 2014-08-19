cj(function ($) {
  // The "source" is the DOM selector that triggers the lookup (ex: postcode field)
  if (! CRM.regionlookup.source) {
    return;
  }

  cj.fn.crmRegionLookup = function() {
    return this.each(function() {
      $this = cj(this);

      if ($this.hasClass('crm-regionlookup-processed')) {
        return;
      }

      $this.addClass('crm-regionlookup-processed');

      $this.change(function() {
        if (! $this.val()) {
          return;
        }

        var query = CRM.url('civicrm/regionlookup/postcode/') + $this.val() + '.json';

        $.getJSON(query, function(data) {
          if (data) {
            $.each(data, function(key, val) {
              if (key != 'source' && CRM.regionlookup[key]) {
                $(CRM.regionlookup[key]).val(val).change();
              }
            });
          }

          // Call a custom callback function, if any.
          // FIXME: this sounds really wrong.
          // Should be an anon function in the $(foo).crmRegionLookup() call?
          // FIXME: do not rely on $this being passed as an argument. Need to find a cleaner way.
          if (CRM.regionlookup.callback) {
            eval(CRM.regionlookup.callback + '(data, $this)');
          }
        });
      });
    });
  };

  // Always enable on the main element
  cj(CRM.regionlookup.source).crmRegionLookup();

  // After ajax calls, check to see if there are new elements to handle.
  $(document).ajaxComplete(function(event, request, settings) {
    cj(CRM.regionlookup.source).crmRegionLookup();
  });
});
