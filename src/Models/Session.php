<?php namespace Nord\Lumen\OAuth2\DynamoDB\Models;

use Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel;

/**
 * Class Session.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Models
 *
 * @property int    $clientId
 * @property string $ownerType
 * @property string $ownerId
 * @property string $clientRedirectUrl
 */
class Session extends DynamoDbModel
{
    /**
     * @var string
     */
    protected $table = 'oauth_sessions';

    /**
     * @var array
     */
    protected $fillable = [
        'clientId',
        'ownerType',
        'ownerId',
        'clientRedirectUri',
    ];
}
