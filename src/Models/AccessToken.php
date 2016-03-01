<?php namespace Nord\Lumen\OAuth2\DynamoDB\Models;

use Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel;

/**
 * Class AccessToken.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Models
 *
 * @property int    $sessionId
 * @property string $token
 * @property string $expireTime
 */
class AccessToken extends DynamoDbModel
{

    /**
     * @inheritdoc
     */
    protected $table = 'oauth_access_tokens';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'sessionId',
        'expireTime',
    ];

    /**
     * @inheritdoc
     */
    protected $guarded = ['token'];

    /**
     * @inheritdoc
     */
    protected $primaryKey = 'token';

    /**
     * @param string $token
     *
     * @return AccessToken|null
     */
    public static function findByToken($token)
    {
        return self::find($token);
    }
}
