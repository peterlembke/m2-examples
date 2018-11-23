Controller
==========
How to use controllers.
 Action controllers implement the \Magento\Framework\App\ActionInterface interface. Usually, they extend the \Magento\Framework\App\Action\Action class.
 You always return  \Magento\Framework\Controller\ResultInterface
 
With a controller you can: 
* vendor/magento/framework/Controller/Result/Json.php
* vendor/magento/framework/Controller/Result/Forward.php
* vendor/magento/framework/Controller/Result/Raw.php
* vendor/magento/framework/View/Result/Page.php
* vendor/magento/framework/Controller/Result/Redirect.php
 In this demo I will explore those return types

Magento documentation
---------------------
The Magento documentation about controllers
https://devdocs.magento.com/guides/v2.2/extension-dev-guide/routing.html

Basic setup to get a controller
-------------------------------
You need
* etc/adminhtml/routes.xml - for admin routes. The front name must be unique. Can not be the same as for frontend.
* etc/frontend/routes.xml - for frontend routes. The front name must be unique. Can not be the same as for admin.

Action
------
Each action is one file that extends \Magento\Framework\App\Action\Action
 You must have a public function execute()

No route handler
----------------
You can set up a no route handler and give it a priority. It will become a global handler.
 You have to check the front name etc if you want it to work only for your module.
 etc/di.xml
 CharZam\Controller\Controller\NoRouteHandler.php

Return Json
-----------
If the frontend do an ajax request then you can return json data.
 In this example I also show how you can use a parameter in the URL.
 CharZam\Controller\Controller\Cname\Ajson.php

Forward
-------
Here you can set a module, controller, action name and parameters in an array and forward that request.
 In the example I point to the Ajson action.
 The browser URL will never change. This forward is internally in Magento.
 CharZam\Controller\Controller\Cname\Aforward.php

Redirect
--------
Redirect the request to another url. Also sets the parameter. The visible request URL will change in the browser
 http://local.mydomain.se/charzam_controller/cname/aredirect/my_parameter/my_redirect
 We forward to Ajson in this module. Result would be:
 http://local.mydomain.se/charzam_controller/cname/ajson/my_parameter/my_redirect/
 {"input":"my_redirect","output":"tcerider_ym"}

Raw
---
With raw you can give a raw response. Useful for downloading binary files.
 In the example we just see the README.md file printed on screen.

Page
----
This one need some more setup. Look at:
* Controller/Cname/Apage.php
* Block - Class that will be used in the template files. 
* view - Contain the layout file for this url. And the template files.

Todo
----
POST parameters
GET parameters
AJAX calls
