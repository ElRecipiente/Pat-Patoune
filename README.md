# Pat-Patoune  

## START THE PROJECT
First, install dependencies : *composer install*
Next, just need to use the symfony command : *symfony server:start*

### CONFIGURE MAILER
Enable send mail in local
You can red this doc https://www.axess.fr/blog/conception-web/tester-lenvoi-demails-en-local-avec-une-configuration-offline-pour-apache

For windows modify php.ini to set *smtp_port = 1025*

Install MailHog width Docker with this command : *docker run -d -p 1025:1025 -p 8025:8025 mailhog/mailhog*

Edit your .env and .env.test :
*MAILER_DSN=smtp://localhost:1025*

### CONFIGURE CRON
Use Scheduler : *composer require symfony/scheduler*

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
