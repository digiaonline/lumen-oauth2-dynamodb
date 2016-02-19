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
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'oauth_access_tokens';

    /**
     * @var array
     */
    protected $fillable = [
        'sessionId',
        'token',
        'expireTime',
    ];

    /**
     * @param string $token
     *
     * @return AccessToken
     */
    public static function findByToken($token)
    {
        return self::where('token', $token)->get()->first();
    }
}
