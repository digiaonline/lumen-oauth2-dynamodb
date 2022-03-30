# lumen-oauth2-dynamodb
DynamoDB support for the lumen-oauth2 module.

# Getting started

Configure your DynamoDB server, either with the local standalone, or the one in AWS. 
If locally, make sure the DynamoDB server is running.

Edit your `Kernel.php` file, and add the following commands to the commands list:

```php
protected $commands = [
    ...
    'Nord\Lumen\OAuth2\DynamoDB\Console\Commands\CreateTablesCommand',
    'Nord\Lumen\OAuth2\DynamoDB\Console\Commands\CreateClientCommand',
];
```

This will introduce two new commands to artisan:

```sh
php artisan oauth2:dynamodb:create
php artisan oauth2:dynamodb:client
```

The first command will create the necessary OAuth2 tables in your DynamoDB.
The latter will create a record in the `oauth_clients` table with information from your .env file.

You will need the following environment variables defined:

```
OAUTH2_CLIENT_ID=<CLIENT_ID>
OAUTH2_CLIENT_SECRET=<CLIENT_SECRET>
OAUTH2_CLIENT_NAME=<CLIENT_NAME>
```

You may set the `ProvisionedThroughput.ReadCapacityUnits/WriteCapacityUnits` for the tables with the following environment variables:

```
OAUTH2_CLIENTS_DYNAMODB_READ_CAPACITY_UNITS=10
OAUTH2_CLIENTS_DYNAMODB_WRITE_CAPACITY_UNITS=20
OAUTH2_SESSIONS_DYNAMODB_READ_CAPACITY_UNITS=10
OAUTH2_SESSIONS_DYNAMODB_WRITE_CAPACITY_UNITS=20
OAUTH2_ACCESS_TOKENS_DYNAMODB_READ_CAPACITY_UNITS=10
OAUTH2_ACCESS_TOKENS_DYNAMODB_WRITE_CAPACITY_UNITS=20
OAUTH2_REFRESH_TOKENS_DYNAMODB_READ_CAPACITY_UNITS=10
OAUTH2_REFRESH_TOKENS_DYNAMODB_WRITE_CAPACITY_UNITS=20
```
The default values are 10 for read capacity and 20 for write capacity. They're quite high values, so you might want
to modify the values to better serve your usage of the `oauth_*` tables.

# License
See [LICENSE](LICENSE).
