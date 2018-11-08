Crontab
=======
You can schedule code to run.

Magento documentation
---------------------
https://devdocs.magento.com/guides/v2.2/config-guide/cron/custom-cron-ref.html

crontab.xml
-----------
You define your cron jobs in etc/crontab.xml
```
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Cron:etc/crontab.xsd">
    <group id="default">
        <job name="charzam_crontab_cron_savecurrenttime" instance="CharZam\Crontab\Cron\SaveCurrentTime" method="execute">
            <schedule>*/15 * * * *</schedule>
        </job>
    </group>
</config>
```

Name - is a unique name in the system. You can have any unique name you want.
Instance - is the path to the class you want to run.
Method - Any public function you want to run in the Instance.
Schedule - when you want your code to run. IF omitted it will run every minute. See more details below in "Configure the schedule".

Groups
------
Magento Cron place cron jobs in groups. Each group will have its own crontab process. This means that if a job in the "default" group crash, then the "index" group will continue in their process.
There are two standard groups: default, index
You usually use default unless you have created a custom indexer. 

If you need to define your own group then that is possible too.
See doc: https://devdocs.magento.com/guides/v2.2/config-guide/cron/custom-cron-ref.html
 
Here is how the default group is defined in its cron_groups.xml
```
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Cron:etc/cron_groups.xsd">
    <group id="default">
        <schedule_generate_every>15</schedule_generate_every>
        <schedule_ahead_for>20</schedule_ahead_for>
        <schedule_lifetime>15</schedule_lifetime>
        <history_cleanup_every>10</history_cleanup_every>
        <history_success_lifetime>10080</history_success_lifetime>
        <history_failure_lifetime>10080</history_failure_lifetime>
        <use_separate_process>0</use_separate_process>
    </group>
</config>
```

Configure the schedule
----------------------
See details here: https://www.mageplaza.com/devdocs/magento-2-create-cron-job/

* * * * *
| | | | |
| | | | +----- Day of week (0 - 7) (Sunday=0 or 7)
| | | +------- Month (1 - 12)
| | +--------- Day of month (1 - 31)
| +----------- Hour (0 - 23)
+------------- Minute (0 - 59)

Examples: 
https://tecadmin.net/crontab-in-linux-with-20-examples-of-cron-schedule/

The Cron folder
---------------
You can place your code anywhere. Most people put the code in Cron so it is easy to find.
I have named the file to what it does. You do not have to extend any class.
I have one public function i each file. You can have more than one if you want.
It is somewhat common to use "execute" as function name. But you do as you wish.

Virtual types
-------------
You can schedule a virtual type to run. Here is an example from Magento_Sales
In di.xml

```
    <virtualType name="SalesOrderIndexGridAsyncInsertCron" type="Magento\Sales\Cron\GridAsyncInsert">
        <arguments>
            <argument name="asyncInsert" xsi:type="object">SalesOrderIndexGridAsyncInsert</argument>
        </arguments>
    </virtualType>
```
In crontab.xml
```
        <job name="sales_grid_order_async_insert" instance="SalesOrderIndexGridAsyncInsertCron" method="execute">
            <schedule>* * * * *</schedule>
        </job>
```
So in this example you see that Magento\Sales\Cron\GridAsyncInsert will run every minute but the argument "asyncInsert" will be the object "SalesOrderIndexGridAsyncInsert".
This is argument replacement. See example "DiExample".

Run once
--------
Your jobs are scheduled regularly. There is no "Run on 2100-01-01 at 08:00".
Instead you have to check in your cron class if you should run the job or not.

Disable a job
-------------
If you for example do not want newsletters to be sent out from Magento you can define your own job with the same name
```
<crontab>
    <jobs>
        <newsletter_send_all>
            <schedule><cron_expr></cron_expr></schedule>
        </newsletter_send_all>
    </jobs>
</crontab>
```
Make sure your module depend on Magento_Newsletter so that your crontab.xml definition is read last.

https://magento.stackexchange.com/questions/62066/how-to-disable-magento-crontab-job#102221

How it works
------------
Your system (Linux/Mac OS) has a crontab service. In that service you must set up so Magento is triggered. (See below)
Crontab runs "magento cron:run".
Magento put items in table "cron_schedule" that will be run later.

Set up crontab
--------------
Your Linux/Mac system have a crontab that runs under the current user.
You must make sure that Magento is in your crontab or else nothing will work.

See your crontab with
```
crontab -e
```
If there is nothing in there you can exit (Shift : then write q and press enter) and run

```
magento cron:install
```
that will add what Magento needs to the crontab for the current user.

You can see if it is working by looking in the table "cron_schedule". 
Magento put new entries here that will be ran by the scheduler.

Read more here 
https://devdocs.magento.com/guides/v2.2/config-guide/cli/config-cli-subcommands-cron.html

Area
----
The crontab is running its code in the crontab area. That means you have access to global config and crontab config.
If your cron code listen to events then you can put them in etc/crontab/events.xml
By doing so Magento do not have to include that configuration when serving an admin user or a frontend user.
It saves resources.

Read more here:
https://devdocs.magento.com/guides/v2.2/architecture/archi_perspectives/components/modules/mod_and_areas.html

Example
-------
In this example module we have a class that write the current time to a file.
You can also ask the class and get the file contents.
 
There is a console command that trigger the class to add the current time stamp, and then the console command ask for 
the file contents and displays that in the console.

```
magento charzam:crontab:run
```

We also have a crontab definition that runs every minute. The cron class will use the class above to add the current time to the file.

You can wait some minutes and run the console command. The result could look like this:
```
2018-11-08 09:38:13 - Added by: console command
2018-11-08 09:38:05 - Added by: Cron
2018-11-08 09:37:04 - Added by: Cron
2018-11-08 09:36:04 - Added by: Cron
2018-11-08 09:35:04 - Added by: Cron
2018
```
