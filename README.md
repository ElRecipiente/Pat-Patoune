# Pat-Patoune  

## TUTORIAL : How we made this project  

### REQUIRED  
Install project in webapp mode : *symfony new PatPatoune --webapp --version=lts*  
Use EasyAdmin : *composer require easycorp/easyadmin-bundle*  
Use Doctrine : *composer require symfony/orm-pack && composer require --dev symfony/maker-bundle (optional, cause we used --webapp)*  

### DATABASE & MIGRATION  
Enable the right DATABASE_URL in .env : *DATABASE_URL="mysql://username:password@127.0.0.1/PatPatoune?serverVersion=8.0.36-0ubuntu0.22.04.1&charset=utf8mb4"*  
Create database : *php bin/console doctrine\:database\:create*  
Create entities : *php bin/console make:entity Entity*  
Make migrations & migrate : *php bin/console make:migration && php bin/console doctrine\:migrations\:migrate*  

### CRUD & DASHBOARD  
Generate CRUD : *php bin/console make:crud Entity*  
Generate Dashboard : *php bin/console make\:admin\:dashboard*  
Generate CRUD for EasyAdmin: *php bin/console make\:admin\:dashboard*  


### USER  
Create user : *php bin/console make:user*  
  => Fields can be added to User after creation with php bin/console make:entity User  

### CREATE LOGIN FORM  
Generate Dashboard :  *php bin/console make:security:form-login*  
Generate Controller : *php bin/console make:controller Login*  

### CREATE REGISTER FORM  
Install dependencie : *composer require symfonycasts/verify-email-bundle*  
Generate Controller : *php bin/console make:controller Login*  
