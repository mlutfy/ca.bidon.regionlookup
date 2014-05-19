CiviCRM Region Lookup
=====================

Lookup and complete form fields from a given key (ex: postcode).

Written and maintained by (C) Mathieu Lutfy, 2010-2013
http://www.bidon.ca/en/about

To get the latest version of this module:
https://github.com/mlutfy/ca.bidon.regionlookup

Distributed under the terms of the GNU Affero General public license (AGPL).
See LICENSE.txt for details.

IMPORTANT: 2013-06-18: this extension is work in progress. I am in the
process of "porting" (adapting) the drupal-based module to a pure CiviCRM
extension. The old version is available here:
https://github.com/mlutfy/CiviCRM-RegionLookup

Features
========

This module does a lookup in the database on a given field (postcode)
in order to auto-complete other fields of a CiviCRM form. The most common
use case is to help donors/members to lookup their riding, based on their
postcode (in Canada, the ridings per postcode are usually unique).

Requirements
============

- CiviCRM >= 4.3 (latest CiviCRM version recommended)
- optional: feeds, feeds_ui, ctools, job_scheduler 7.x-2.0-[...] to import CSV files

Warning for nginx
=================

Under the nginx web server, you may need to add a configuration to
allow .json requests to pass. Otherwise the .json requests will return
a 404 error code (c.f. your Firebug network console).

I have limited experience with nginx, so if you have found the correct
config fix for this, please let me know so we can document it.
https://github.com/mlutfy/ca.bidon.regionlookup

Installation
============

1- Download this extension and unpack it in your 'extensions' directory.
   You may need to create it if it does not already exist, and configure
   the correct path in CiviCRM -> Administer -> System -> Directories.

2- Enable the extension from CiviCRM -> Administer -> System -> Extensions.

WARNING: for now, the module assumes that the user has the "access CiviCRM"
permission to use this module. This hasn't been tested on sites with anonymous
access to specific forms. Permission are defined in xml/Menu/regionlookup.xml.

The old drupal-based module integrated with "Feeds" to expose an interface
to import CSV files. I'm not sure how to do this in pure CiviCRM, e.g. whether
we can plug into the main csv import interface, or need to write a custom one.

Once the module is enabled, a new admin menu will be added to:
CiviCRM > Administer > System Settings > Region Lookup Settings
The direct URL is: /civicrm/admin/setting/regionlookup?reset=1

Once your data is imported, you can test that the lookup works, for example:
http://example.org/civicrm/regionlookup/postcode/h1h2h2.json

**Field association configuration:**

You need to configure which field triggers a lookup (ex: postcode)
and what fields will be updated (district, borough, ridings, etc).

This works by using DOM elements from the HTML, since most of the
work is done in javascript.

So for example, your DOM element for the postcode will be similar to:
.billing_name_address-section input#billing_postal_code-5

And this can update a custom field in your "post profile" section of
the contribution form:
.custom_post_profile-group #custom_1

You can find the correct DOM selector by using the "inspect element"
feature of your browser (Firefox, Chrome). If you are not familiar
about DOM elements, search the web for "jQuery selectors", which are
in fact pretty much the same as "CSS selectors".

In short, the example:
.billing_name_address-section input#billing_postal_code-5

basically says: find an element with the class "billing_name_address-section"
(it may be a <div> or anything else), and in that element, find an "input"
element with an ID "billing_postal_code-5" (the "#" means "id", "." means "class").

For more information, see:
https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Getting_Started/Selectors

**Documentation from the old Drupal module for feeds:**

1- Enable kt_district, services, feeds, etc.

  drush dl services feeds ctools job_scheduler
  drush en feeds_ui

This module does not explicitely depend on feeds_ui, so that you can
disable it once you have finished importing your CSV files.

2- Create a new Feeds parser:

 - Go to: Site building > Feed importer (admin/structure/feeds)
 - Click on "Add importer"

  -- Name: CiviCRM Region Lookup Importer (doesn't really matter)
  -- click save

You will then need to edit the following settings:

 - Basic settings: Periodic import: off
 - Fetcher: change for "File upload"
 - File upload settings: allowed file extentions: csv
 - Parser: select the "CSV" parser
 - CSV settings: select accordingly to your CSV file format.
 - Processor: change for "civicrm_regionlookup processor"
 - Processor settings: these are mostly ignored for now.
 - Processor mapping: configure them accordingly.

3- Import the districts CSV file

 - Go to: Structure > Feeds importer (admin/structure/feeds)

IMPORTANT: your postcodes must be in lower case and with no spaces.
(todo: we should improve the feeds processor to fix this automatically.)


Extending
=========

The module can call your own custom callback when data is looked up.

Define your custom callback function name in the region lookup settings
then write a function in a .js file already loaded by your site (in a
custom extension/module or theme).

For example:

// Custom callback for civicrm_regionlookup
function mymodule_regionlookupcallback(data) {
  if (data && data.borough) {
    // do something here
  }
  else {
    jQuery('.custom_pre_profile-group #postal_code-1').attr('style', 'background-color: #FBE3E4;');
    jQuery('.custom_pre_profile-group .postal_code-1-section .content').append('<span class="mymodule-postcode-invalid">' + Drupal.t('Invalid postcode.') + '</span>');
  }
}

In this case, the callback function defined in the admin settings
was "mymodule_regionlookupcallback". This is not like Drupal hooks.
If you know a more standard way of doing this, let me know!

Support
=======

Please post bug reports in the issue tracker of this project on github:
https://github.com/mlutfy/ca.bidon.regionlookup/issues

This is a community contributed extension written thanks to the financial
support of organisations using it, as well as the very helpful and collaborative
CiviCRM community.

If you appreciate this module, please consider donating 10$ to the CiviCRM project:
http://civicrm.org/participate/support-civicrm

While I do my best to provide volunteer support for this extension, please
consider financially contributing to support or development of this extension
if you can.
http://www.bidon.ca/en/paypal

