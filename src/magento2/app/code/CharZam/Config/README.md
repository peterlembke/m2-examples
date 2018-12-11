Config
======
How to use configuration. 
Use system.xml, config.xml, set sensitive data, set system data.

In this module we will set some basic config in config.xml
and we will see config in admin with system.xml
And finally we will change the fallback config.

Magento documentation
---------------------
The Magento documentation about configuration is vaste.
https://devdocs.magento.com/guides/v2.2/config-guide/config/config-magento.html

This module will focus on admin settings.
https://devdocs.magento.com/guides/v2.2/config-guide/prod/config-reference-var-name.html

Here is an example from MagePlaza
https://www.mageplaza.com/magento-2-module-development/create-system-xml-configuration-magento-2.html

And a guide from Atwix
https://www.atwix.com/magento-2/system-configuration/

config.xml
-----------
Here you can set basic values on the settings.

system.xml
----------
Here you define how it should look like in admin.

Data types
----------
Each field you define in admin have a type. It tells what type of field you want to display. It does not say what type of data you want to store.
```
<field id="enabled" translate="label" type="select" sortOrder="10" showInDefault="1" showInWebsite="0" showInStore="0">
    <label>Enable</label>
    <source_model>Magento\Config\Model\Config\Source\Yesno</source_model>
</field>
```
Here is a list with all types available.
https://magento.stackexchange.com/questions/155869/magento-2-available-field-types-in-system-xml#155870

checkbox,
checkboxes,
column,
date,
editablemultiselect,
editor,
fieldset,
file,
gallery,
hidden,
image,      -
imagefile,
label,      -
link,
multiline,
multiselect,
note,
obscure,    - 
password,   -
radio,
radios,
reset,
select,     -
submit,
text,       - 
textarea,   -
time

Rights (ACL)
------------
Access Control Lists (ACL) is a way to regulate who is seeing what in admin.
 You set up admin users and admin groups in admin. The groups can get different rights.
 All features are listed and you can select what the group members should see.

https://www.atwix.com/magento-2/system-configuration/
 https://www.mageplaza.com/magento-2-module-development/magento-2-acl-access-control-lists.html

If you do not have an etc/acl.xml in your code then only super users can use the feature and you have no possibility to let a group use the feature.

Sensitive data
--------------
Sensitive data are data that will be encrypted before stored in the database.
The doc for sensitive data is here:
https://devdocs.magento.com/guides/v2.2/config-guide/prod/config-reference-sens.html

system data
-----------
The doc for system data is here:
https://devdocs.magento.com/guides/v2.2/config-guide/prod/config-reference-sens.html

```
```

Data source
-----------
You can use the already existing data sources or you can create your own.
```

```


Hide settings
-------------
You can get settings to show depending on other settings. See below example where "enabled" will show "compamy_name" if enabled.
```
<field id="enabled" translate="label" type="select" sortOrder="10" showInDefault="1" showInWebsite="1" showInStore="0">
    <label>Enable</label>
    <source_model>Magento\Config\Model\Config\Source\Yesno</source_model>
</field>
<field id="company_name" translate="label comment" type="text" sortOrder="20" showInDefault="1" showInWebsite="1" showInStore="0">
    <depends>
        <field id="*/*/enabled">1</field>
    </depends>
    <label>Company name</label>
</field>
```

Validate
--------
You can put validation rues on all the fields.
It seems that the names are the same as the css classes you use in frontend.
http://blog.i13websolution.com/magento-2-validation-rules/
I have tested 
<validate>validate-no-empty</validate>
<validate>validate-email</validate>
and they work as expected. You also get a small popup that explain what is expected in the field.

min_text_length
max_text_length
max-words
min-words
range-words
letters-with-basic-punc
alphanumeric
letters-only
no-whitespace
zip-range
integer
vinUS
dateITA
dateNL
time
time12h
phoneUS
phoneUK
mobileUK
stripped-min-length
email2
url2
credit-card-types
ipv4
ipv6
pattern
validate-no-html-tags
validate-select
validate-no-empty
validate-alphanum-with-spaces
validate-data
validate-street
validate-phoneStrict
validate-phoneLax
validate-fax
validate-email
validate-emailSender
validate-password
validate-admin-password
validate-url
validate-clean-url
validate-xml-identifier
validate-ssn
validate-zip-us
validate-date-au
validate-currency-dollar
validate-not-negative-number
validate-zero-or-greater
validate-greater-than-zero
validate-css-length
validate-number
validate-number-range
validate-digits
validate-digits-range
validate-range
validate-alpha
validate-code
validate-alphanum
validate-date
validate-identifier
validate-zip-international
validate-state
less-than-equals-to
greater-than-equals-to
validate-emails
validate-cc-number
validate-cc-ukss
required-entry
checked
not-negative-amount
validate-per-page-value-list
validate-new-password
validate-item-quantity
equalTo

Todo
----
ACL - Rights
Config.xml - start values, both for global and for specific website
Sensitive data - things that are stored in env.php and perhaps in config.php
