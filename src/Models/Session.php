<?php namespace Nord\Lumen\OAuth2\DynamoDB\Models;


use Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel;

class Session extends DynamoDbModel
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'oauth_sessions';

    /**
     * @var array
     */
    protected $fillable = [
        'client_id',
        'owner_type',
        'owner_id',
        'client_redirect_uri',
    ];
}
