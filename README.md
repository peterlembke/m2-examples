# m2-examples
Magento 2.2 example modules to show how things work in M2.2

DiExample
---------
With di.xml you can do dependency injection, substitute a class, extend a class, change class arguments, create virtual type.

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/DiExample

Plugins
-------
With Plugins you get access to the variables before they are given to a function, 
and you get access to the return value before it is sent to the caller.

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/Plugins

UseProxy
--------
You can delay initialization of classes until they are really used. That is done with a proxy.
No need to change any code at all, just configure in di.xml that you want this on some class injections. Magento take care of the rest. This can Improove performance!!.

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/UseProxy

Factory
-------
With a factory object you can create new empty objects of a specific type.
For example when you want to create new customers or products.
This example is also about singleton (shared objects).

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/Factory

Events
------
You can dispatch events and attach any data. In your observer you get READ ONLY data that you can act on.
If you need to send data back, then use a plugin instead.

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/Events

Crontab
-------
With cron you can schedule tasks to run regularily. In this module you see how to set up jobs, deparate business logic and test the job. The documentation is a bit more extensive in this module.

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/Crontab

Config
------
You can create your own Admin config. See this module how it is done.

https://github.com/peterlembke/m2-examples/tree/master/src/magento2/app/code/CharZam/Config

Controller
----------
React on the URLs with controllers. In this example you learn how to redirect or forward a request. How to return a page or a json or a raw response. How to make a no route that catch those URLs that no one else have catched.

Database
--------
Store data in a table. How to add data, read, write, delete, search data.


# Resources
Resources how you can study Magento 2 more in depth.

Background
----------
There are now five different certifications you can take for Magento 2.2.
https://u.magento.com/certification

Certifications
--------------
- MAGENTO 2 CERTIFIED SOLUTION SPECIALIST
- MAGENTO 2 CERTIFIED ASSOCIATE DEVELOPER EXAM
- MAGENTO 2 CERTIFIED PROFESSIONAL FRONT END DEVELOPER
- MAGENTO 2 CERTIFIED PROFESSIONAL JAVASCRIPT DEVELOPER
- MAGENTO 2 CERTIFIED PROFESSIONAL DEVELOPER

Below are resources for the MAGENTO 2 CERTIFIED PROFESSIONAL DEVELOPER exam.

The test day
------------
You get practical tips what awaits on the test day.

https://www.integer-net.com/magento-2-certified-professional-developer-about-the-exam/

https://www.mw2consulting.com/blog/tips-prepare-magento-2-developer-certification-exam

Swift Otter study guide
-----------------------
Swift Otter give you a large PDF with a lot of information in every area. Very useful.

https://swiftotter.com/technical/certifications/magento-2-certified-developer-study-guide

Exam notes
----------
Exam notes is a very useful condensed material that have a lot of references to other pages.

https://github.com/magento-notes/magento2-exam-notes

Magento 2.2 study guide
-----------------------
The official study guide is not very useful except for the intimidating examples in there.

https://u.magento.com/free-study-guide

Alan Storm in depth articles
----------------------------
You can always trust Alan Storm to have the detailed analyzes of different M2 areas.

https://alanstorm.com/category/magento-2/

Magento documentation
---------------------
The Magento documentation is a valuable source.
You will end up here by reference if you follow the "Exam notes" above.

https://devdocs.magento.com/#/individual-contributors

Technical guidelines
--------------------
Very useful document that show the intent from Magento, how they expect code to be written.

https://devdocs.magento.com/guides/v2.2/coding-standards/technical-guidelines.html

Study group
-----------
Magento also has study groups.

https://u.magento.com/magento-2-certified-developer-study-group#.W9rPm3pKgZJ
