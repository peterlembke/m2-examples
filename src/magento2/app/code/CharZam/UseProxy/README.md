UseProxy
=========
When you use dependency injection then all classes will be initialized and their class constructor will inject what it needs and so on in a chain.
So if you only sometimes use the class then it would be better if that class would initialize when you actually want to use it.
That is exactly what a proxy does.

In this example I inject three classes. Class1 initialize quickly, Class2 takes 1 second, Class3 takes 2 seconds.
And depending on what command you run it will use one function from one of the classes. It is a waste of time to initialize all the classes.

That is why they are using a proxy instead.

Where do I insert a proxy?
--------------------------
In di.xml you can use normal class arguments to insert the class you want. If you add \Proxy to the end then a proxy class will be automatically created.

```
    <type name="CharZam\UseProxy\Command\Class1Test">
        <arguments>
            <argument name="class1" xsi:type="object">\CharZam\UseProxy\Model\Class1\Proxy</argument>
            <argument name="class2" xsi:type="object">\CharZam\UseProxy\Model\Class2\Proxy</argument>
            <argument name="class3" xsi:type="object">\CharZam\UseProxy\Model\Class3\Proxy</argument>
        </arguments>
    </type>
```

You will find the proxy class in 

generated/code/CharZam/UseProxy/Model/Class1/Proxy.php

It is this class that are called when you use a function in the class. Now it will instantiate the class and pass the call to the function you want.

The file are automatically created if you run Magento in developer mode.
In production mode it is created when you run 
```magento setup:di:compile```

Run the test
------------
There are three commands you can run.

```magento charzam:useproxy:class1test```

Result:
function_foo=""; class_foo="class1 foo"; class_name="CharZam\UseProxy\Model\Class1"; time="0.00025510787963867";

```magento charzam:useproxy:class2test```

Result:
function_foo=""; class_foo="class2 foo"; class_name="CharZam\UseProxy\Model\Class2"; time="1.0048677921295";
Here you see that the 1 second slow initialization process for Class2 shows when we use the function.

```magento charzam:useproxy:class3test```

Result:
function_foo=""; class_foo="class3 foo"; class_name="CharZam\UseProxy\Model\Class3"; time="2.0040881633759";
Here you see that the 2 second slow initialization process for Class3 shows when we use the function.
