This is an example of REST service.
==================================

How it works
------------
The index.php file gets and handles requests:
* GET /Products — to get all products
* GET /Products/{id} — to get a product with a specified id
* PUT /Products — to put(add) new product
* POST /Products/{id} – to edit a book info with a specified id 
* DELETE /Products/{id} – to remove a book with a specified id 

Classes
-------
* Product – the main class which describes the product object
* ProductsAPI – the API to work with Product objects
* ProductsController – the controller to handle users' requests
 
Tests
-----
There are some tests in /tests directory. They check ProductsAPI implementation.
