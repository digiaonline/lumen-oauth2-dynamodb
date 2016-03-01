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
     * @inheritdoc
     */
    protected $table = 'oauth_refresh_tokens';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'accessTokenId',
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
     * @return RefreshToken|null
     */
    public static function findByToken($token)
    {
        return self::find($token);
    }
}
