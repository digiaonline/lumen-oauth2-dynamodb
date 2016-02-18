<?php namespace Nord\Lumen\OAuth2\DynamoDB\Storages;

use Crisu83\ShortId\ShortId;
use Nord\Lumen\OAuth2\DynamoDB\Models\AccessToken;
use Nord\Lumen\OAuth2\DynamoDB\Models\Client;
use Nord\Lumen\OAuth2\DynamoDB\Models\Session;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\SessionInterface;
use Nord\Lumen\OAuth2\Exceptions\ClientNotFound;
use Nord\Lumen\OAuth2\Exceptions\SessionNotFound;

/**
 * Class SessionStorage.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Storages
 */
class SessionStorage extends DynamoDBStorage implements SessionInterface
{

    /**
     * @inheritdoc
     */
    public function getByAccessToken(AccessTokenEntity $entity)
    {
        $accessToken = AccessToken::findByToken($entity->getId());

        /** @var Session $session */
        $session = Session::find($accessToken->sessionId);

        if ($session === null) {
            throw new SessionNotFound;
        }

        return $this->createEntity($session);
    }

    /**
     * @inheritdoc
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @inheritdoc
     */
    public function getScopes(SessionEntity $session)
    {
    }

    /**
     * @inheritdoc
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $client = Client::findByKey($clientId);

        if ($client === null) {
            throw new ClientNotFound;
        }

        $session = new Session([
            'clientId'          => $client->getKey(),
            'ownerType'         => $ownerType,
            'ownerId'           => $ownerId,
            'clientRedirectUri' => $clientRedirectUri,
        ]);

        $session->setId(ShortId::create()->generate());
        $session->save();

        return $session->getKey();
    }

    /**
     * @inheritdoc
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @param Session $session
     *
     * @return SessionEntity
     */
    protected function createEntity(Session $session)
    {
        $entity = new SessionEntity($this->server);

        $entity->setId($session->getKey());
        $entity->setOwner($session->ownerType, $session->ownerId);

        return $entity;
    }
}
