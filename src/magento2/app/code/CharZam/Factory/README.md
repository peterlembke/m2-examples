Factory example
===============
Objects you get with dependency injection are singletons. Singleton means that you always get the same object every time you ask for the object.
Singletons are also called "Shared objects".

Class objects you use in your dependency injections should do something. They should be stateless and contain code.

There are also other objects that represent something, like a specific product or a specific customer.
They have a state, the data is specific. They are not suitable for sharing or reuse.

When you need a new object you usually request a factory object that can produce new empty objects.

Load a customer
---------------
If you want a specific customer object then you use
```
$customer = $this->_customerRepository->getById($id);
```
You only need to inject the customerRepository object and you get a customer object from that repository.

Create a new customer
---------------------
If you want to create a new customer then you need a new empty customer object to fill with data and let the customerRepository save that customer object.
You need a Factory object that can produce new empty customer objects.

Read about Factory
------------------
The excellent official documentation will explain more.
https://devdocs.magento.com/guides/v2.2/extension-dev-guide/factories.html

Note in the end of that doc that you can still inject Interface classes, you just add "Factory" at the end to get a factory object.

Example module
--------------
The example module show you how to:
* create a customer factory
* inject a class that will be a new instance

Run like this
```
magento charzam:factory:run
```

Expected result:
```
customer factory="Magento\Customer\Api\Data\CustomerInterfaceFactory"; 
customer object="Magento\Customer\Model\Data\Customer"; 
class1 object="CharZam\Factory\Model\Class1";
```

Sharing = false
---------------
Again: Objects you get with dependency injection are singletons.
If you for some reason have a class that you always want to be injected as a new object then you can write this in your di.xml

```
<type name="CharZam\Factory\Model\Class1" shared="false"></type>
```

The default is that all injected classes are shared.
