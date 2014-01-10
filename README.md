Resources
===============

###Overview
Resource Finder is a simple framework that allows users to set up a defined set of weblinks and categories, and use filters and search to narrow down search results. It was built by two Harvard students, Anne Madoff '15 and Balaji Pandian '15,  to make it easier to find the web resources most useful to students.  It stores a list of URLs and categories in a table, and the UI allows easy and intuitive filter and search.  It also has a cvs file upload and download capability tomake it easy to update the URLs without having to access the database directly with SQL.     

It is a PHP application using the CodeIgniter framework and sqlite database.

The application is now maintainted and run by Harvard University Information Technology, and is available here as an open source applicatoin.  

###Quickstart
1) Clone the repository to a webserver set up with php and sqlite3.

2) You should be able to access the search page at <your domain>/CampusResources/

3) In order to use the script that will allow you to update the database via importing a csv file, go to the directory CampusResources/app/application/controllers and change the name of update.php.disabled to update.php.   [We have it disabled on our production instance for obvious securty reasons...]

4) The sqlite data file is in CampusResources/tree/master/app/db and called campus_resources.sqlite.  If you are not familiar with sqlite, you can access the database by running sqlite3 campus_resources.sqlite.  (This application can also be easily modified to use mysql.  (In fact, the original version was mysql, but it seemed overkill for such a simple datamodel, so we switched to sqlite, at least for now.) 

5) To upload your own list of URLs, you can upload your own list by going to the following URL:

<yourdomain>/CampusResources/app/index.php/update/  (assuming you've already updated update.php by renaming it... set item 3 abve.) 

###Possible Pitfalls
If you want to set up different categories than those outlined here, you will need to modify the CampusResources/app/application/models/link.php file, as the categories are hardcoded there, and must match the categories in the database to be displayed. (either by modifying directly via the database, or by uploading a csv file.

###Datamodel
Currently the database has a single table called "links" 

###Credit
This is a web application aimed at making it easier for students to find Harvard specific web resources. The original application was created by Anne Madoff '15 and Balaji Pandian '15. 
