<?php namespace Nord\Lumen\OAuth2\DynamoDB\Models;

use Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel;

/**
 * Class RefreshToken.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Models
 *
 * @property int    $accessTokenId
 * @property string $token
 * @property string $expireTime
 */
class RefreshToken extends DynamoDbModel
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'oauth_refresh_tokens';

    /**
     * @var array
     */
    protected $fillable = [
        'accessTokenId',
        'token',
        'expireTime',
    ];

    /**
     * @param string $token
     *
     * @return RefreshToken
     */
    public static function findByToken($token)
    {
        return self::where('token', $token)->get()->first();
    }
}
