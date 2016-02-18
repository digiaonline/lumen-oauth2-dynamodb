<?php namespace Nord\Lumen\OAuth2\DynamoDB\Models;

use Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel;

class Client extends DynamoDbModel
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'oauth_clients';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'secret',
    ];


    /**
     * @param string $key
     *
     * @return Client
     */
    public static function findByKey($key)
    {
        return self::where('key', $key)->first();
    }


    /**
     * @param int $sessionId
     *
     * @return Client
     */
    public static function findBySessionId($sessionId)
    {
        return self::where('session_id', $sessionId)->first();
    }
}
