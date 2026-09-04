## Steps to test the code

1) Extract the files from the archive to your desired folder.
2) Retrieve needed packages / modules.
```bash
    composer install
    npm install
```
3) Update the DB CONNECTION info in the .env file to match your created mysql database information.
4) Run the migrations to initialize the database.
```bash
    php artisan migrate
```
5) Run the project locally using the command below and then browse to http://127.0.0.1:8000 to use the project.
```bash
    php artisan serve
```
NOTE: You must first create at least one project before you can start adding tasks. 

NOTE: You can run basic feature tests on the Tasks Model by running the following command: 
```bash
    php artisan test
```