<?php
/**
 * Create OAuth2 DynamoDB tables.
 */
namespace Nord\Lumen\OAuth2\DynamoDB\Console\Commands;

/**
 * Class CreateTablesCommand.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Console\Commands
 */
class CreateTablesCommand extends \Nord\Lumen\DynamoDb\Console\CreateTablesCommand
{

    /**
     * @var string $name The name of the command.
     */
    protected $name = 'oauth2:dynamodb:create';

    /**
     * The name and signature of the command.
     *
     * @var string $signature The signature of the command.
     */
    protected $signature = 'oauth2:dynamodb:create';

    /**
     * @var string $description The description of the command.
     */
    protected $description = 'Create the necessary OAuth2 tables.';

    /**
     * Run the command.
     */
    public function handle()
    {
        self::$tables = include_once( sprintf('%s/../../database/migrations/oauth2Tables.php', __DIR__) );
        $this->createTables();
    }
}
