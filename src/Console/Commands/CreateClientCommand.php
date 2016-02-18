<?php
/**
 * Create OAuth2 client record.
 */
namespace Nord\Lumen\OAuth2\DynamoDB\Console\Commands;

use Crisu83\ShortId\ShortId;
use Illuminate\Console\Command;
use Nord\Lumen\DynamoDb\Contracts\DynamoDbClientInterface;
use Nord\Lumen\OAuth2\DynamoDB\Models\Client;

/**
 * Class CreateTablesCommand.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Console\Commands
 */
class CreateClientCommand extends Command
{

    /**
     * @var string $name The name of the command.
     */
    protected $name = 'oauth2:dynamodb:client';

    /**
     * The name and signature of the command.
     *
     * @var string $signature The signature of the command.
     */
    protected $signature = 'oauth2:dynamodb:client';

    /**
     * @var string $description The description of the command.
     */
    protected $description = 'Create the necessary client record.';

    /**
     * @var DynamoDbClientInterface $dynamoDb The DynamoDb interface.
     */
    protected $dynamoDb;

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
        $client = new Client([
            'key'  => env('OAUTH2_CLIENT_ID'),
            'name' => env('OAUTH2_CLIENT_NAME'),
        ]);

        // We need to manually generate the id for the client.
        $client->setId(ShortId::create()->generate());
        // The secret is guarded, so set it manually here.
        $client->setAttribute('secret', env('OAUTH2_CLIENT_SECRET'));

        if ($client->save()) {
            $this->info('Client created.');
        } else {
            $this->error('Could not save client');
        }
    }
}
