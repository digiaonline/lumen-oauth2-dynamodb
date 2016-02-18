<?php
/**
 * Create OAuth2 DynamoDB tables.
 */
namespace Nord\Lumen\OAuth2\DynamoDB\Console\Commands;

use Illuminate\Console\Command;
use Nord\Lumen\DynamoDb\Contracts\DynamoDbClientInterface;

/**
 * Class CreateTablesCommand.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Console\Commands
 */
class CreateTablesCommand extends Command
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
     * @var DynamoDbClientInterface $dynamoDb The DynamoDb interface.
     */
    protected $dynamoDb;

    /**
     * List of tables to create.
     *
     * @var array $tables
     */
    protected static $tables = [
        [
            'TableName'             => 'oauth_clients',
            'AttributeDefinitions'  => [
                [
                    'AttributeName' => 'id',
                    'AttributeType' => 'S',
                ],
            ],
            'KeySchema'             => [
                [
                    'AttributeName' => 'id',
                    'KeyType'       => 'HASH',
                ],
            ],
            // ProvisionedThroughput is required
            'ProvisionedThroughput' => [
                // ReadCapacityUnits is required
                'ReadCapacityUnits'  => 10,
                // WriteCapacityUnits is required
                'WriteCapacityUnits' => 20,
                'OnDemand'           => false,
            ],
        ],
        [
            'TableName'             => 'oauth_sessions',
            'AttributeDefinitions'  => [
                [
                    'AttributeName' => 'id',
                    'AttributeType' => 'S',
                ],
            ],
            'KeySchema'             => [
                [
                    'AttributeName' => 'id',
                    'KeyType'       => 'HASH',
                ],
            ],
            // ProvisionedThroughput is required
            'ProvisionedThroughput' => [
                // ReadCapacityUnits is required
                'ReadCapacityUnits'  => 10,
                // WriteCapacityUnits is required
                'WriteCapacityUnits' => 20,
                'OnDemand'           => false,
            ],
        ],
        [
            'TableName'             => 'oauth_access_tokens',
            'AttributeDefinitions'  => [
                [
                    'AttributeName' => 'id',
                    'AttributeType' => 'S',
                ],
            ],
            'KeySchema'             => [
                [
                    'AttributeName' => 'id',
                    'KeyType'       => 'HASH',
                ],
            ],
            // ProvisionedThroughput is required
            'ProvisionedThroughput' => [
                // ReadCapacityUnits is required
                'ReadCapacityUnits'  => 10,
                // WriteCapacityUnits is required
                'WriteCapacityUnits' => 20,
                'OnDemand'           => false,
            ],
        ],
        [

            'TableName'             => 'oauth_refresh_tokens',
            'AttributeDefinitions'  => [
                [
                    'AttributeName' => 'id',
                    'AttributeType' => 'S',
                ],
            ],
            'KeySchema'             => [
                [
                    'AttributeName' => 'id',
                    'KeyType'       => 'HASH',
                ],
            ],
            // ProvisionedThroughput is required
            'ProvisionedThroughput' => [
                // ReadCapacityUnits is required
                'ReadCapacityUnits'  => 10,
                // WriteCapacityUnits is required
                'WriteCapacityUnits' => 20,
                'OnDemand'           => false,
            ],
        ],
    ];

    /**
     * Class constructor.
     *
     * @param DynamoDbClientInterface $dynamoDb
     */
    public function __construct(DynamoDbClientInterface $dynamoDb)
    {
        parent::__construct();
        $this->dynamoDb = $dynamoDb;
    }

    /**
     * Run the command.
     */
    public function handle()
    {
        $client = $this->dynamoDb->getClient();

        foreach (self::$tables as $table) {
            $tableName = $table['TableName'];
            $this->info(sprintf('Checking if table "%s" exists.', $tableName));
            if ( ! $this->tableExists($tableName)) {
                $this->comment(sprintf('Creating table %s', $tableName));
                $client->createTable($table);
                $client->waitUntil('TableExists', array(
                    'TableName' => $tableName,
                ));

                $this->info(sprintf('Table "%s" created.', $tableName));
            } else {
                $this->warn(sprintf('Table "%s" already exists.', $tableName));
            }
        }
    }

    /**
     * Checks if the given table exists.
     *
     * @param string $tableName The table name to check.
     *
     * @return bool True if the table exists, false otherwise.
     */
    protected function tableExists($tableName)
    {
        $iterator = $this->dynamoDb->getClient()->getIterator('ListTables');
        foreach ($iterator as $table) {
            if ($table === $tableName) {
                return true;
            }
        }

        return false;
    }
}
