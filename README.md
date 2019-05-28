1. clone this repo 

2. run "composer install" into the root directory

3. Into .htacces change the RewriteBase directive to point to your directory.
   Mine is /batorus/smartvalue ("batorus" is the alias for my app directory).
   All the requests are being made through the index.php file.

4. install the database provided in the root directory: "locations_countries.sql"

5. Set your credentials in "app/Database/PDOConnection.php"




