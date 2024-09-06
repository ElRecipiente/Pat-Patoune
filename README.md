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
*VISIT_NOTIFICATION_DELAY=27*  you can choose how many days before you want send the notification

## TUTORIAL : How we made this project  

### REQUIRED  
Install project in webapp mode : *symfony new PatPatoune --webapp --version=lts*  
Use EasyAdmin : *composer require easycorp/easyadmin-bundle*  
Use Doctrine : *composer require symfony/orm-pack && composer require --dev symfony/maker-bundle (optional, cause we used --webapp)*  

### DATABASE & MIGRATION  
Enable the right DATABASE_URL in .env : *DATABASE_URL="mysql://username:password@127.0.0.1/PatPatoune?serverVersion=8.0.36-0ubuntu0.22.04.1&charset=utf8mb4"*  
Create database : *php bin/console doctrine:database:create*  
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

### CONFIGURE CRON TASK

(if not present) Generate command : *php bin/console make:command SendMailCommand* and

**Configure cron task :**
 - Linux :

    run : *crontab -e*

    run : *0 7* * * * */path/to/php /path/to/project/bin/console send:visit-notifications*
    
    (For exemple : 0 7 * * * /usr/bin/php /home/user/projects/Pat-Patoune/bin/console send:visit-notifications)


 - Windows :

    run : *schtasks /create /sc minute /mo 1 /tn "SendMailTask" /tr "\"C:\path\to\php\php.exe\" \"C:\path\to\project\bin\console\" app:send-mail"*

    (For exemple : schtasks /create /sc daily /tn "SendMailTask" /tr "\"C:\wamp64\bin\php\php8.2.13\php.exe\" \"C:\---CODE---\SIMPLON_2024\Pat-Patoune\bin\console\" send:visit-notifications" /st 07:00)

    To delete this task : *schtasks /delete /tn "SendMailTask" /f*


**Define how many days before visit send notification**

in .env define *VISIT_NOTIFICATION_DELAY=27* and adapt the delay


**All days at 7 an email send at all user witch the visit is in VISIT_NOTIFICATION_DELAY**

