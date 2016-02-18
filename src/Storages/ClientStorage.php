<?php namespace Nord\Lumen\OAuth2\DynamoDB\Storages;

use Nord\Lumen\OAuth2\DynamoDB\Models\Client;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\ClientInterface;
use Nord\Lumen\OAuth2\Exceptions\ClientNotFound;

/**
 * Class ClientStorage.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Storages
 */
class ClientStorage extends DynamoDBStorage implements ClientInterface
{

    /**
     * @inheritdoc
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        $client = Client::findByKey($clientId);

        if ($client === null) {
            throw new ClientNotFound;
        }

        return $this->createEntity($client);
    }


    /**
     * @inheritdoc
     */
    public function getBySession(SessionEntity $entity)
    {
        $client = Client::findBySessionId($entity->getId());

        if ($client === null) {
            throw new ClientNotFound;
        }

        return $this->createEntity($client);
    }


    /**
     * @param Client $client
     *
     * @return \League\OAuth2\Server\Entity\ClientEntity
     */
    protected function createEntity(Client $client)
    {
        $entity = new ClientEntity($this->server);

        $entity->hydrate([
            'id'   => $client->key,
            'name' => $client->name,
        ]);

        return $entity;
    }
}
