Database
========
Example module that show how you can use resource models to store data in a table in the database.

A setup script that create a new table "charzam_database_workout"
 A resource model that handle the table.
 A command so you can set/get values from the table.
 A command so you can search in the database and see results

Setup the table
---------------
The file Setup/InstallSchema.php creates the 

Model and Resource model
------------------------
I have created a model that represent one item (row) in the table. Workout.
 And a repository that handle load and save of one row. WorkoutRepository.
 The repository also use the resourceModel and the resourceModel Collection to get access to the table.

Search
------
In the WorkoutRepository you have the function getList. It wants a SearchCriteria and will give you a SearchResult.

I have provided three different ways to do a query.
 Direct SQL should not be used but sometimes that is the only sane alternative.
 Using a collection is the smoothest way. This is how it was done in Magento 1. M2 can do this too.
 Using a searchCriteria is how it is supposed to be done in Magento 2.
 
You probably notice the ridiculous amount of code needed for using the getList() function.  

Read more there how to search with repositories.
https://devdocs.magento.com/guides/v2.2/extension-dev-guide/searching-with-repositories.html

Run example
-----------
You start the example from the magento command
```magento charzam:database:set keyname value```
and then
```magento charzam:database:get keyname```
You can also search.
```magento charzam:database:search 42195```
