Dashboard with additional features which extends the Redmine

Installation:

    1. Download project files (or clone).
    2. Copy and rename "/app/config/parameters.yml.dist" file to "parameters.yml" and change necessary parameters.
    3. Run "composer install" command.
    4. Run "php bin/console doctrine:schema:create".
    5. Run "php bin/console doctrine:schema:update --force".
    6. Go to the "web" directory and run "npm install" command.
    7. When all modules will be installed, run "gulp sass" command.
    
Open a browser and go to your domain.