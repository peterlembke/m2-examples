# m2-examples
Magento 2.2 example modules to show how things work in M2.2

DiExample
---------
With di.xml you can do dependency injection, substitute a class, extend a class, change class arguments, create virtual type.

Plugins
-------
With Plugins you get access to the variables before they are given to a function, 
and you get access to the return value before it is sent to the caller.

UseProxy
--------
You can delay initialization of classes until they are really used. That is done with a proxy.
No need to change any code at all, just configure in di.xml that you want this on some class injections. Magento take care of the rest. This can Improove performance!!.
