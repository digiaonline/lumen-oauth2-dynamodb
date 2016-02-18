# lumen-oauth2-dynamodb
DynamoDB support for the lumen-oauth2 module

# Getting started

Configure your DynamoDB server, either with the local standalone, or the one in AWS. 
If locally, make sure the DynamoDB server is running.

Edit your `Kernel.php` file, and add the following commands to the commands list:

    protected $commands = [
        ...
        'Nord\Lumen\OAuth2\DynamoDB\Console\Commands\CreateTablesCommand',
        'Nord\Lumen\OAuth2\DynamoDB\Console\Commands\CreateClientCommand',
    ];

This will introduce two new commands to artisan:

    php artisan oauth2:dynamodb:create
    php artisan oauth2:dynamodb:client

The first command will create the necessary OAuth2 tables in your DynamoDB.
The latter will create a record in the `oauth_clients` table with information from your .env file.

You will need the following environment variables defined:

    OAUTH2_CLIENT_ID=<CLIENT_ID>
    OAUTH2_CLIENT_SECRET=<CLIENT_SECRET>
    OAUTH2_CLIENT_NAME=<CLIENT_NAME>

# License
MIT
