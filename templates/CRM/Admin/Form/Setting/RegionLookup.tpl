<div class="crm-block crm-form-block crm-regionlookup-form-block">
  <fieldset>
    <legend>{ts}Lookup field{/ts}</legend>
    <div class="help">{ts}Field used for the lookup. This should be the postcode field in the CiviCRM billing block of contribution forms. If empty, it will disable the lookup function. Use the "inspect element" function of your browser to determine the correct selector.{/ts}</div>

    <table class="form-layout-compressed">
      <tr>
        <td class="label">{$form.source.label}</td>
        <td>{$form.source.html}<br />
          <span class="description">{ts}For example: .billing_name_address-section input#billing_postal_code-5{/ts}</span>
        </td>
      </tr>
      <tr>
        <td class="label">{$form.searchprefix.label}</td>
        <td>{$form.searchprefix.html}<br />
          <span class="description">{ts}This allows to find the closest match. For example, you may have the H1H postcode mapped to a value, with the exception of H1H 2A2 mapped to another value.{/ts}</span>
        </td>
      </tr>
{*
      <tr>
        <td class="label">{$form.searchwildcard.label}</td>
        <td>{$form.searchwildcard.html}<br />
          <span class="description">{ts}This allows to search on partial matches. Makes sense mostly if used with the other options below. <strong>TODO: not implemented yet.</strong>{/ts}</span>
        </td>
      </tr>
      <tr>
        <td class="label">{$form.searchonkeyup.label}</td>
        <td>{$form.searchonkeyup.html}<br />
          <span class="description">{ts}Launches the search after each character typed by the user. Useful for partial matches with autocomplete. <strong>TODO: not implemented yet.</strong>{/ts}</span>
        </td>
      </tr>
      <tr>
        <td class="label">{$form.searchchars.label}</td>
        <td>{$form.searchchars.html}<br />
          <span class="description">{ts}For example, if your lookup only requires the first 3 digits of a postcode to find a match, enter 3 in this field. <strong>TODO: not implemented yet.</strong>{/ts}</span>
        </td>
      </tr>
*}
    </table>
  </fieldset>

  <fieldset>
    <legend>{ts}Lookup method{/ts}</legend>
    <div class="help">{ts}The default lookup method uses values in the 'civicrm_regionlookup' database table. You can configure external lookup sources with the help of third-party extensions. See the extension's README file for more information.{/ts}</div>

    <table class="form-layout-compressed">
      <tr>
        <td class="label">{$form.lookup_method.label}</td>
        <td>{$form.lookup_method.html}</td>
      </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend>{ts}Destination fields{/ts}</legend>
    <div class="help">{ts}Field updated by the lookup. For example, the postcode lookup may update a region field, state/country riding, etc. Use the "inspect element" function of your browser to determine the correct selector. For example: the selector for a custom field ID 1 in a post profile is: .custom_post_profile-group #custom_1{/ts}</div>

    <table class="form-layout-compressed">
      <tr>
        <td class="label">{$form.district.label}</td>
        <td>{$form.district.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.borough.label}</td>
        <td>{$form.borough.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.city.label}</td>
        <td>{$form.city.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.county.label}</td>
        <td>{$form.county.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.state.label}</td>
        <td>{$form.state.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.country.label}</td>
        <td>{$form.country.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.postcode.label}</td>
        <td>{$form.postcode.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.stateriding.label}</td>
        <td>{$form.stateriding.html}</td>
      </tr>
      <tr>
        <td class="label">{$form.countryriding.label}</td>
        <td>{$form.countryriding.html}</td>
      </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend>{ts}Custom overrides{/ts}</legend>
    <div class="help">{ts}Custom javascript function to call with the resulting data. This allows you to write your own custom callbacks and override how the response is handled.{/ts}</div>

    <table class="form-layout-compressed">
      <tr>
        <td class="label">{$form.callback.label}</td>
        <td>{$form.callback.html}</td>
      </tr>
    </table>
  </fieldset>

  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>

  <p class="crm-regionlookup-about">{ts 1="http://www.gnu.org/licenses/agpl-3.0.html"}Region Lookup is a CiviCRM extension openly available under the <a href="%1">GNU AGPL License</a>.{/ts} {ts 1="https://github.com/mlutfy/ca.bidon.regionlookup"}For new versions, bug reports or support, visit the <a href="%1">project page on github</a>.{/ts}</p>
</div>
