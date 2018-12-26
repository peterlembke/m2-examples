Database
========
Example module that show how you can use resource models to store data in a table in the database.

A setup script that create a new table "charzam_database_workout"
 A resource model that handle the table.
 A command so you can set/get values from the table.

Run example
-----------
You start the example from the magento command
```magento charzam:database:set keyname value```
and then
```magento charzam:database:get keyname```

How does it work?
-----------------

Define the database in di.xml
----------------------------
Check the di.xml file in this module and you see how the database are defined.

```
    <preference for="CharZam\Database\Api\Class1Interface" type="CharZam\Database\Model\Class1"/>

    <type name="CharZam\Database\Model\Class1">
        <plugin name="charzam_database_plugin_model_class1"
                type="CharZam\Database\Plugin\Model\Class1"
                sortOrder="10"
                disabled="false"/>
        <plugin name="charzam_database_plugin_model_class1again"
                type="CharZam\Database\Plugin\Model\Class1Again"
                sortOrder="20"
                disabled="false"/>
    </type>

    <type name="CharZam\Database\Api\Class1Interface">
        <plugin name="charzam_database_plugin_model_class1Interface"
                type="CharZam\Database\Plugin\Model\Class1Again"
                sortOrder="5"
                disabled="false"/>
    </type>
```

You can put database on classes or interfaces.

In this example we have three database on the same class "Class1".

Why a plugin on the interface class?
------------------------------------
If the preference in di.xml are changed to another class than Class1 then the two database that go directly to Class1 will no longer work.
The plugin that point to the Interface will still work. 
