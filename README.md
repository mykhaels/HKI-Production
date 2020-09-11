1. Installation Admin LTE
Require the package using composer:

composer require jeroennoten/laravel-adminlte
(Laravel 7+ only) Require the laravel/ui package using composer:

composer require laravel/ui
php artisan ui:controllers
Install the package using the command (For fresh laravel installations):

php artisan adminlte:install
You can use --basic to avoid authentication scaffolding installation

You can use --force to overwrite any file

You can also use --interactive to be guided through the process and choose what you want to install


2. Installation Chartisan
You can install Laravel Charts by using Composer

You can use the following composer command to install it into an existing laravel project.

composer require consoletvs/charts "7.*"

Laravel will already register the service provider to your application because laravel charts does make use of the extra laravel tag on the composer.json schema.

#Publish the configuration file
You can publish the configuration file of Laravel charts by running the following command:

php artisan vendor:publish --tag=charts
This will create a new file under app/config/charts.php that you can edit to modify some of the options of Laravel Charts.

