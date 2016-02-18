<?php namespace Nord\Lumen\OAuth2\DynamoDB\Storages;

use League\OAuth2\Server\Storage\ScopeInterface;

class ScopeStorage extends DynamoDBStorage implements ScopeInterface
{

    /**
     * @inheritdoc
     */
    public function get($scope, $grantType = null, $clientId = null)
    {
        throw new \Exception('Not implemented');
    }
}
