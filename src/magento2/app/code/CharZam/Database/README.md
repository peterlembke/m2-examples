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

Search with SQL
---------------
You should never use SQL directly on the database.
 With that said you can always do everything without SQL but it can get complicated.
 For simple and medium advanced selects it is best to avoid SQL.
 For updates you should ALWAYS avoid SQL.

 See function: Model/WorkoutRepository.php -> getItemsArrayByDistanceAndCompetition

Search with a collection
------------------------
Using a collection is the smoothest way. This is how it was done in Magento 1. M2 can do this too.
 Few lines to write, few dependencies. There are more modern ways to do this.
 
 See function: Model/WorkoutRepository.php -> getCollectionByDistanceAndCompetition
 
Search with search critera
--------------------------
You can use search critera to search. 
 In the WorkoutRepository you have the function getList. It wants a SearchCriteria and will give you a SearchResult.
 Using a searchCriteria is how it is supposed to be done in Magento 2.
 
See function: Model/WorkoutRepository.php -> getSearchResultByDistanceAndCompetition
 You probably notice the ridiculous amount of code needed for using the getList() function.
 To reduce the amount of code you can use a searchCriteriaBuilder. See the next section. 

Search with search critera builder
----------------------------------
You can use a search critera builder to build the searchCriteria object. 
 In the WorkoutRepository you have the function getList. It wants a SearchCriteria and will give you a SearchResult.
 Using a searchCriteria is how it is supposed to be done in Magento 2.

More about search
-----------------
Read more there how to search with repositories.
https://devdocs.magento.com/guides/v2.2/extension-dev-guide/searching-with-repositories.html

Run example
-----------
In the table charzam_database_workout you can first set up the test data.


You start the example from the magento command
```magento charzam:database:set```
and then
```magento charzam:database:get```
You can also search.
```magento charzam:database:search```
You can also search with the search criteria builder.
```magento charzam:database:search2```
