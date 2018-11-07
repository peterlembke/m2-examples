Events
======
You can listen to events (Event Observer) and you can throw events.

In this module you can throw an event by running
```
magento charzam:events:run
```
The event listener triggers and a text are written to the console.

Dispatch an event
-----------------
You need the \Magento\Framework\EntityManager\EventManager to dispatch an event.
You can see how it is done in CharZam\Events\Command\Run

```
        $this->eventManager->dispatch('charzam_events_done_before', array(
            'message' => 'I will soon write Done in the console',
            'output_interface' => $output
        ));
```
You are free to put any variables in the array. I wanted to send a message and a reference to the console so I can do writeln in the observer.
See Command/Run.php

Event observer
--------------
Put the observer class in the Observer folder.
Create etc/events.xml and define the global event listeners there.
If your event will be used in a specific area (frontend, adminhtml, base, crontab, webapi_rest, webapi_soap).
Just create a subfolder and put the events.xml there. etc/frontend/events.xml

```
<event name="charzam_events_done_before">
    <observer name="charzam_events_done_before" instance="CharZam\Events\Observer\DoneBefore" />
</event>
```

Do not have any business logic in your observer. Instead put that in a separate class and do dependency injection into your observer. 

Modify objects
--------------
The data you send in an event are only values. That is true for scalar (basic) data types like integer, float, string, array.
It is not true for objects, because objects are sent by reference.

Example 1 - modify an object:
You have a table in the database with json data that you want to send to an importer.
In the data it says what importer name it is. You ask the table for data that you have not yet successfully sent.
You put the data in a data object and send it away with an event.
If there exist an importer with the right name it will now handle the data and put a flag in the object how it went.
The event sender will get the object back, see the flag and set it on the data in the table as imported OK.

The above example is working well, but Magento do not want you to send data back to the caller.
Magento want you to consider all incoming objects in an object observer to be read only.
Magento want you to instead use plugins to solve the above example.

Example 2 - with plugins
The same example but this time we will solve it with plugins instead.
One function to get the data and now NOT use an event, instead just call function number two.
Second function will get the data and the flag how it went.

Now all handlers will each have a plugin that run before the second function.
If their name is mentioned in the data then they will act on the data.
