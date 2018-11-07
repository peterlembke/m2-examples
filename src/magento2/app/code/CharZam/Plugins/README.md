Plugins
=======
Example module that show how you can use plugins to modify the variables BEFORE they are given to a public function, or modify the return value AFTER it has come from a public function.
You can also define an AROUND call so you can have total control over a function.

Plugins, can and can not
------------------------
You can only use plugins on public functions that are NOT declared final or static.

With $subject you get access to the class object. You can then call public functions, but you do NOT have access to protected or private functions.

DO NOT use plugins to modify classes in the same module as we have done here.

Sort order
----------
Several plugins can exist on the same function. In this example I declare both before, after and around - twice.
The sortOrder declare who is called first.

See the output of this example at the bottom of this document and you will notice that:
The plugin with the LOWEST sortOrder will start running.

before (sortOrder 10)
around - first half (sortOrder 10)
before (sortOrder 20)
around - first half (sortOrder 20)
around - second half (sortOrder 20)
after (sortOrder 20)
around - second half (sortOrder 10)
after (sortOrder 10)

before
------
Occur before the function call. You can modify the parameters that will go into the function.
You add all variables as parameters to the function.
You return all parameters in an array in the same order.
You have access to $subject if you want to run any public functions.

after
-----
Occur directly after the function call. You can modify the return parameters before they are passed on to the caller.
The $result variable contain the return value from the function. You can react on the value and perhaps modify it before you return it.

around
------
If you want to substitute a function with some other logic, then "around" is your feature.
All function variables come in the function call.
You get a $procede variable that you can call. If you do not then the rest of the plugins will not run.
You can test what happens if you change Plugin/Model/Class1.php like this

```    public function aroundMyPublicFunction($subject, $procede, $foo=0)
       {
           echo 'Calling' . __METHOD__ . ' -- before' . " IN=" . $foo . "\n";
   
           $foo++;
   
           // $result = $procede($foo);
           $result = array(
               'function_foo' => $foo,
               'class_foo' => '',
               'class_name' => ''
           );
           echo 'Calling' . __METHOD__ . ' -- after' . " IN=" . $result[self::VALUE] . "\n";
   
           $result[self::VALUE]++;
   
           return $result;
       }
```

The result would be:
```Calling CharZam\Plugins\Plugin\Model\Class1::beforeMyPublicFunction IN=10
   CallingCharZam\Plugins\Plugin\Model\Class1::aroundMyPublicFunction -- before IN=11
   CallingCharZam\Plugins\Plugin\Model\Class1::aroundMyPublicFunction -- after IN=12
   Calling CharZam\Plugins\Plugin\Model\Class1::afterMyPublicFunction IN=13
   function_foo="14"; class_foo=""; class_name=""; 
```
This might very well be the result you want. Compare this result with the one below.

When you call $procede you must also add all variables in the right order.

Run example
-----------
You start the example from the magento command
```magento charzam:plugins:run```

Check the di.xml for the definition.

The result:
```
Calling CharZam\Plugins\Plugin\Model\Class1::beforeMyPublicFunction IN=10
CallingCharZam\Plugins\Plugin\Model\Class1::aroundMyPublicFunction -- before IN=11
Calling CharZam\Plugins\Plugin\Model\Class1Again::beforeMyPublicFunction IN=12
CallingCharZam\Plugins\Plugin\Model\Class1Again::aroundMyPublicFunction -- before IN=13
CallingCharZam\Plugins\Plugin\Model\Class1Again::aroundMyPublicFunction -- after IN=14
Calling CharZam\Plugins\Plugin\Model\Class1Again::afterMyPublicFunction IN=15
CallingCharZam\Plugins\Plugin\Model\Class1::aroundMyPublicFunction -- after IN=16
Calling CharZam\Plugins\Plugin\Model\Class1::afterMyPublicFunction IN=17
function_foo="18"; class_foo="class1 foo"; class_name="CharZam\Plugins\Model\Class1\Interceptor"; 
```

How does it work?
-----------------
Check in generated/code/CharZam/Plugins/Model/Class1/Interceptor.php
It is this class that are called and it will reroute the request to the right plugin function.

The file are automatically created if you run in developer mode.
In production mode it is created when you run 
```magento setup:di:compile```
