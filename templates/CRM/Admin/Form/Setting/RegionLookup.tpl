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

  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
