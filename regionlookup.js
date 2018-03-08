cj(function ($) {
  // The "source" is the DOM selector that triggers the lookup (ex: postcode field)
  if (! CRM.regionlookup.source) {
    return;
  }

  cj.fn.crmRegionLookup = function(country) {
    return this.each(function() {
      $this = cj(this);

      if ($this.hasClass('crm-regionlookup-processed')) {
        return;
      }

      $this.addClass('crm-regionlookup-processed');

      $this.change(function() {
        crmFetchData($this, country);
      });
      $this.click(function() {
        crmFetchData($this, country);
      });
    });
  };

  // Always enable on the main element
  cj(CRM.regionlookup.source).crmRegionLookup(CRM.regionlookup.source_country);

  // After ajax calls, check to see if there are new elements to handle.
  $(document).ajaxComplete(function(event, request, settings) {
    cj(CRM.regionlookup.source).crmRegionLookup(CRM.regionlookup.source_country);
  });

  function crmFetchData(selector, country) {

    if (! $this.val()) {
      return;
    }
    country_selected = cj(country + ' option:checked').val();
    var excluded_fields = ['source','source_country'];

    if (country_selected != '') {
      var query = CRM.url('civicrm/regionlookup/postcode/') + country_selected + '/' + $this.val() + '.json';
    } else {
      var query = CRM.url('civicrm/regionlookup/postcode/') + 'all/' + $this.val() + '.json';
    }

    $.getJSON(query, function(data) {
      if (data) {
        // If one or less results found, act normally
        if (data.length <= 1) {
          $.each(data, function(key, val) {
            $.each(val, function(keyint, valint) {
              if ((keyint != 'source' && CRM.regionlookup[keyint]) && (keyint != 'source_country' && CRM.regionlookup[keyint])) {
                $(CRM.regionlookup[keyint]).val(valint).change();
              }
            });
          });
        } else {
          cities = ts("Multiple results were found. Please select your preferred option by clicking on the link(s) below");
          cities += '<ul>';
          // More than one data is found
          $.each(data, function(key, val) {
            $.each(val, function(keyint, valint) {
              if ((keyint != 'source' && CRM.regionlookup[keyint]) && (keyint != 'source_country' && CRM.regionlookup[keyint])) {
                $(CRM.regionlookup[keyint]).val(valint).change();
                if (keyint === 'city') {
                  var link_constructor = '<a href="#" title=' + keyint + ' onclick="cj(\'' + CRM.regionlookup[keyint] + '\').val(\''+valint+'\').change();return false;">' + valint + '</a>';
                  cities += '<li class="suggested-' + key +'">' + ts('City') + ': '  + link_constructor + '</li>';
                }
              }
            });
          });
          cities += '</ul>';
          cities += ts("Please select a city");
          // Show a warning in the form of a dialogue
          CRM.$('<div class="multicities_selector"></div>').dialog({
            modal: true,
            width: 500,
            height: 400,
            title: ts("Multiple results found"),
            open: function() {
              $(this).html(cities);
            },
            buttons: {
              Ok: function() {
                $( this ).dialog( "close" );
              }
            }
          });  //end confirm dialog

        }
      }

      // Call a custom callback function, if any.
      // FIXME: this sounds really wrong.
      // Should be an anon function in the $(foo).crmRegionLookup() call?
      // FIXME: do not rely on $this being passed as an argument. Need to find a cleaner way.
      if (CRM.regionlookup.callback) {
        eval(CRM.regionlookup.callback + '(data, $this)');
      }
    });
  }


});
