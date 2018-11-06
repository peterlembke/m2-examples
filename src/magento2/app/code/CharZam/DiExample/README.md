DiExample
=========
Example module that show how you can use di.xml to
extend a class and modify a function in that new extended class.
extend a class and inject other arguments than the original ones.
expend a class, inject a virtual object that have been modified in di.xml to get new arguments.

Dependency injection
--------------------
You do not use classes directly in Magento 2, instead you have a constructor function and insert all classes as parameters to the function.

```    protected $class3;
   
       public function __construct(
           Class3 $class3,
           $name = null
       )
       {
           $this->class3 = $class3;
           parent::__construct($name);
       }
```

Then you put the variables in class variables so they can be used in the class.

```$result = $this->class3->myPublic2(70);```

substitute a class
------------------
Classes that are declared with an interface, they can be substituted so your own class that use the same interface will be used INSTEAD of the original class.
This is done globally. If several modules want to substitute the same class then the last one that ask will be the winner.
In di.xml you see the declaration:
```<preference for="CharZam\DiExample\Api\MyObjectInterface" type="CharZam\DiExample\Model\MyObject1"/>```
It connects the interface with the class. 
You can in your modules di.xml do the same declaration and exchange CharZam\DiExample\Model\MyObject1 with your class instead.
You are free to extend or not extend the original class. 

extend a class
--------------
Some times you just want to modify the logic inside of a function and use that function in your module while the rest of the functions will work the same as before.
You can then extend the original class and declare your own function with the same name. You can call the parent function if you want to inside of your function.

You can see how this is done in Class2, Class3, Class4. They are all extending Class1 but they do not affect Class1.
All the four classes can be used individually. You can see that in Class1Test, Class2Test, Class3Test, Class4Test where each class are added in the constructor and used in the code.
The function myPublic2 are never changed in any of the Class2,3,4 and work as it does in Class1.
The function myPublicFunction are modified in each class but they are also calling the original function in Class1.

When you do this you can use the extended class in your construct function. It will not affect any other part of the system.

You can modify functions that are declared with public or protected.
You can not modify functions that are declared with private or final.

class arguments
---------------
The variables you insert in the constructor function are arguments.
In this case we have $startValue = 1

```
   namespace CharZam\DiExample\Model;
   use CharZam\DiExample\Api\MyObjectInterface;
   
   class MyObject2 implements MyObjectInterface
   {
       protected $startValue;
   
       public function __construct(
           $startValue = 1
       ) {
           $this->startValue = $startValue;
       }
   
       public function getStartValue($addThis = 0) {
           return $this->startValue + $addThis + 100;
       }
   }
```


You can change the value of the arguments by defining that in di.xml
```    <type name="CharZam\DiExample\Model\MyObject2">
           <arguments>
               <argument name="startValue" xsi:type="number">16</argument>
           </arguments>
       </type>
```

In the above example the $startValue will now be 16. And we did not have to change the code.
If several modules change the startValue, then the last di.xml that are read will win. EXCEPT for arrays, they are merged together from all di.xml files.

You must have the same data type as before. And the valid data types are:
"array" // Are not overwritten, instead the array are merged between all di.xml
"string"
"boolean"
"object"
"configurableObject"
"number" // Allows both integer and float values
"null"
"object"
"init_parameter" // Same as const
"const"

virtual type
------------
If you set new arguments on a class then those arguments are set globally for that class.
What if you have a class that you want to change arguments for but only when you use it in a specific place.
You can then define a virtual type that is based on your class. Change the arguments,

```
    <virtualType name="CharZam\DiExample\Model\MyObject4" type="CharZam\DiExample\Model\MyObject3">
        <arguments>
            <argument name="startValue" xsi:type="number">10000</argument>
        </arguments>
    </virtualType>
```
and then use the virtual type to substitute a dependency injection
```
    <type name="CharZam\DiExample\Model\Class4">
        <arguments>
            <argument name="foo" xsi:type="string">New DI foo 4</argument>
            <argument name="myObject" xsi:type="object">\CharZam\DiExample\Model\MyObject4</argument>
        </arguments>
    </type>
```
In the above example name is a unique name of the virtual type. To be unique I have set a name of "CharZam\DiExample\Model\MyObject4".
It looks like a class name but actually there are no class there, it is just a unique string.

Class4 is a real class.
"\CharZam\DiExample\Model\MyObject4" is the name of the virtual class.

When the above are run you will see that Class4 will use MyObject3, and that MyObject3 have startValue 10000
, but only in this configuration. MyObject3 have not been affected by this.
